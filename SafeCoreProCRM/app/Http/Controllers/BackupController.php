<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BackupController extends Controller
{
    public function index()
    {
        // O Spatie salva por padrão na pasta 'Laravel' dentro de storage/app/
        $disk = Storage::disk('local');
        $files = $disk->files(env('APP_NAME', 'Laravel'));

        $backups = [];
        foreach ($files as $file) {
            if (substr($file, -4) == '.zip') {
                $backups[] = [
                    'file_path' => $file,
                    'file_name' => str_replace(env('APP_NAME', 'Laravel') . '/', '', $file),
                    'file_size' => round($disk->size($file) / 1048576, 2) . ' MB', // Converte bytes para MB
                    'last_modified' => Carbon::createFromTimestamp($disk->lastModified($file))->format('d/m/Y H:i:s'),
                ];
            }
        }

        // Ordena para os mais recentes ficarem no topo
        $backups = array_reverse($backups);

        return view('backups.index', compact('backups'));
    }

    public function create()
    {
        try {
            // Dispara o comando de backup apenas do banco de dados de forma silenciosa e limpa os antigos
            Artisan::call('backup:run', ['--only-db' => true, '--disable-notifications' => true]);

            return back()->with('success', __('messages.backup_created'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao gerar backup: ' . $e->getMessage()]);
        }
    }

    public function download($fileName)
    {
        $file = env('APP_NAME', 'Laravel') . '/' . $fileName;

        if (Storage::disk('local')->exists($file)) {
            return Storage::disk('local')->download($file);
        }

        return abort(404, "Arquivo não encontrado.");
    }

    public function destroy($fileName)
    {
        $file = env('APP_NAME', 'Laravel') . '/' . $fileName;

        if (Storage::disk('local')->exists($file)) {
            Storage::disk('local')->delete($file);
            return back()->with('success', __('messages.backup_deleted'));
        }

        return abort(404, "Arquivo não encontrado.");
    }

    public function restore($fileName)
    {
        $file = env('APP_NAME', 'Laravel') . '/' . $fileName;
        $disk = Storage::disk('local');

        if (!$disk->exists($file)) {
            return abort(404, "Arquivo não encontrado.");
        }

        $zipPath = $disk->path($file);
        $extractPath = storage_path('app/temp_backup_extract');

        $zip = new ZipArchive;
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($extractPath);
            $zip->close();

            // O Spatie normalmente guarda o SQL dentro de uma pasta chamada 'db-dumps'
            $sqlFiles = glob($extractPath . '/*/*.sql');
            if (empty($sqlFiles)) {
                $sqlFiles = glob($extractPath . '/*.sql'); // Fallback
            }

            if (!empty($sqlFiles)) {
                $sqlFile = $sqlFiles[0];
                try {
                    // SÊNIOR: Executa o dump SQL bruto no banco de dados atual
                    DB::unprepared(file_get_contents($sqlFile));

                    // Limpa a sujeira
                    File::deleteDirectory($extractPath);

                    return back()->with('success', __('messages.backup_restored'));
                } catch (\Exception $e) {
                    File::deleteDirectory($extractPath);
                    return back()->withErrors(['error' => 'Erro crítico ao restaurar: ' . $e->getMessage()]);
                }
            }

            File::deleteDirectory($extractPath);
            return back()->withErrors(['error' => 'Nenhum arquivo .sql encontrado no ZIP.']);
        }

        return back()->withErrors(['error' => 'Falha ao extrair o arquivo ZIP do backup.']);
    }
}
