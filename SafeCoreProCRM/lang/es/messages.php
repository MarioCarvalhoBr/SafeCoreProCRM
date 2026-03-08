<?php
return [
    'welcome' => 'Bienvenido a SafeCoreProCRM',
    'dashboard' => 'Panel de Control',
    // Navbar & Settings
    'clinic_settings' => 'Configuración de la Clínica',
    'profile' => 'Perfil',
    'log_out' => 'Cerrar Sesión',
    // Patients Module
    'patients' => 'Pacientes',
    'add_patient' => 'Nuevo Paciente',
    'edit_patient' => 'Editar Paciente',
    'save' => 'Guardar',
    'cancel' => 'Cancelar',
    'name' => 'Nombre Completo',
    'email' => 'Correo Electrónico',
    'phone' => 'Teléfono',
    'document_id' => 'Documento de Identidad',
    'birth_date' => 'Fecha de Nacimiento',
    'actions' => 'Acciones',
    'no_patients_found' => 'Aún no hay pacientes registrados.',
    'patient_created_successfully' => '¡Paciente registrado con éxito!',

    'open' => 'Abrir',
    'edit' => 'Editar',
    'delete' => 'Eliminar',
    'confirm_delete' => 'Confirmar Eliminación',
    'delete_patient_text' => '¿Está seguro de que desea eliminar a este paciente? Esta acción no se puede deshacer.',
    'patient_updated_successfully' => '¡Paciente actualizado con éxito!',
    'patient_deleted_successfully' => '¡Paciente eliminado con éxito!',

    // Appointments Module
    'appointments' => 'Citas',
    'add_appointment' => 'Nueva Cita',
    'edit_appointment' => 'Editar Cita',
    'doctor' => 'Médico / Profesional',
    'patient' => 'Paciente',
    'date' => 'Fecha',
    'time' => 'Hora',
    'status' => 'Estado',
    'scheduled' => 'Programada',
    'completed' => 'Completada',
    'canceled' => 'Cancelada',
    'notes' => 'Notas Clínicas',
    'appointment_created_successfully' => '¡Cita programada con éxito!',
    'appointment_updated_successfully' => '¡Cita actualizada con éxito!',
    'appointment_deleted_successfully' => '¡Cita eliminada con éxito!',
    'no_appointments_found' => 'No hay citas programadas.',
    'time_slot_taken' => 'El médico seleccionado ya tiene una cita a esta hora.',

    // Staff / Users
    'staff' => 'Equipo y Usuarios',
    'add_staff' => 'Nuevo Miembro del Equipo',
    'edit_staff' => 'Editar Miembro del Equipo',
    'role' => 'Rol en el Sistema',
    'password' => 'Contraseña',
    'password_confirmation' => 'Confirmar Contraseña',
    'leave_blank_to_keep' => 'Dejar en blanco para mantener la contraseña actual',
    'user_created_successfully' => '¡Miembro del equipo añadido con éxito!',
    'user_updated_successfully' => '¡Miembro del equipo actualizado con éxito!',
    'user_deleted_successfully' => '¡Miembro del equipo eliminado con éxito!',
    'cannot_delete_self' => 'Bloqueo de Seguridad: No puedes eliminar tu propia cuenta de administrador.',

        // PDF & Prescriptions
    'print_prescription' => 'Imprimir Receta',
    'prescription' => 'Receta Médica',
    'patient_name' => 'Nombre del Paciente',
    'doctor_name' => 'Nombre del Médico',
    'date_of_issue' => 'Fecha de Emisión',
    'signature' => 'Firma del Médico / Sello',
    'clinic_contact' => 'Contacto de la Clínica',

    'medical_certificate' => 'Certificado Médico',
    'certificate_days' => 'Días de Reposo',
    'issued_on' => 'Emitido el',
    'certificate_text' => 'Certifico que el paciente arriba mencionado estuvo bajo cuidados médicos en esta fecha y requiere :days día(s) de reposo para su recuperación.',
    'print_certificate' => 'Imprimir Certificado',

    // Audit Logs
    'audit_logs' => 'Registros de Auditoría',
    'action' => 'Acción',
    'user' => 'Realizado Por',
    'module' => 'Módulo / Registro',
    'details' => 'Detalles',
    'created' => 'Creó',
    'updated' => 'Actualizó',
    'deleted' => 'Eliminó',
    'no_logs_found' => 'No se encontraron registros de actividad.',

    // Dashboard
    'welcome_back' => 'Bienvenido(a) de nuevo',
    'total_patients' => 'Total de Pacientes',
    'appointments_today' => 'Citas de Hoy',
    'appointments_month' => 'Citas de este Mes',
    'appointments_by_status' => 'Citas por Estado',
    'appointments_doctor_today' => 'Citas por Médico (Hoy)',
    'appointments_doctor_month' => 'Citas por Médico (Mes)',

    'search' => 'Buscar...',
    'search_button' => 'Buscar',
    'clear' => 'Limpiar',

    'backups' => 'Copias de Seguridad',
    'generate_backup' => 'Generar Copia',
    'download' => 'Descargar',
    'file_name' => 'Nombre del Archivo',
    'file_size' => 'Tamaño',
    'backup_created' => '¡Copia de seguridad generada con éxito!',
    'backup_deleted' => '¡Copia de seguridad eliminada con éxito!',
    'no_backups_found' => 'No se encontraron copias de seguridad.',

    'restore' => 'Restaurar',
    'confirm_restore' => '¿Estás absolutamente seguro? ¡Esto borrará la base de datos actual y la reemplazará con esta copia!',
    'backup_restored' => '¡Base de datos restaurada con éxito!',

    'medical_record' => 'Historial médico',
    'blood_type' => 'Tipo de sangre',
    'allergies' => 'Alergias',
    'family_history' => 'Antecedentes familiares',
    'past_surgeries' => 'Cirugías previas',
    'current_medications' => 'Medicamentos actuales',
    'view_record' => 'Perfil del paciente',

    'appointment_history' => 'Historial de Citas',
    'no_appointments_history' => 'No se encontraron citas para este paciente.',
    'notes' => 'Notas / Síntomas',

    'medical_files' => 'Archivos Médicos y Exámenes',
    'upload_file' => 'Subir Archivo',
    'choose_file' => 'Elegir Archivo (PDF, JPG, PNG)',
    'no_files' => 'Aún no hay archivos subidos.',
    'file_uploaded' => '¡Archivo subido con éxito!',
    'file_deleted' => '¡Archivo eliminado con éxito!',

    'delete_file_warning' => '¿Estás seguro de que deseas eliminar este archivo? Esta acción no se puede deshacer.',



];
