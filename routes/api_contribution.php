<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;

Route::group([
    'middleware' => 'api',
    'prefix' => 'contribution'
], function () {
    // Rutas abiertas
    // Rutas autenticadas con token
    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::get('/list_years', [App\Http\Controllers\Contribution\ImportationController::class, 'list_years']);

        Route::group([
            'middleware' => 'permission:read-import-payroll|create-import-payroll-senasir|create-import-payroll-command'
        ], function () {
            Route::post('/list_months_validate_senasir', [App\Http\Controllers\Contribution\ImportPayrollSenasirController::class, 'list_months_validate_senasir']);
            Route::post('/upload_copy_payroll_senasir', [App\Http\Controllers\Contribution\ImportPayrollSenasirController::class, 'upload_copy_payroll_senasir']);
            Route::post('/validation_payroll_senasir', [App\Http\Controllers\Contribution\ImportPayrollSenasirController::class, 'validation_payroll_senasir']);
            Route::post('/rollback_payroll_copy_senasir', [App\Http\Controllers\Contribution\ImportPayrollSenasirController::class, 'rollback_payroll_copy_senasir']);
            Route::post('/import_payroll_senasir_progress_bar', [App\Http\Controllers\Contribution\ImportPayrollSenasirController::class, 'import_payroll_senasir_progress_bar']);
            Route::post('/download_fail_not_found_payroll_senasir', [App\Http\Controllers\Contribution\ImportPayrollSenasirController::class, 'download_fail_not_found_payroll_senasir']);

            Route::post('/list_months_validate_command', [App\Http\Controllers\Contribution\ImportPayrollCommandController::class, 'list_months_validate_command']);
            Route::post('/upload_copy_payroll_command', [App\Http\Controllers\Contribution\ImportPayrollCommandController::class, 'upload_copy_payroll_command']);
            Route::post('/validation_payroll_command', [App\Http\Controllers\Contribution\ImportPayrollCommandController::class, 'validation_payroll_command']);
            Route::post('/rollback_payroll_copy_command', [App\Http\Controllers\Contribution\ImportPayrollCommandController::class, 'rollback_payroll_copy_command']);
            Route::post('/import_payroll_command_progress_bar', [App\Http\Controllers\Contribution\ImportPayrollCommandController::class, 'import_payroll_command_progress_bar']);
            Route::post('/download_new_affiliates_payroll_command', [App\Http\Controllers\Contribution\ImportPayrollCommandController::class, 'download_new_affiliates_payroll_command']);
        });
        Route::group([
            'middleware' => 'permission:download-report-payroll-senasir|download-report-payroll-command'
        ], function () {
            Route::post('/report_payroll_senasir', [App\Http\Controllers\Contribution\ImportPayrollSenasirController::class, 'report_payroll_senasir']);
            Route::post('/report_payroll_command', [App\Http\Controllers\Contribution\ImportPayrollCommandController::class, 'report_payroll_command']);
        });
        Route::group([
            'middleware' => 'permission:read-import-contribution|create-import-senasir|create-import-command'
        ], function () {
            Route::post('/list_months_import_contribution_senasir', [App\Http\Controllers\Contribution\ImportContributionSenasirController::class, 'list_months_import_contribution_senasir']);
            Route::post('/import_create_or_update_contribution_period_senasir', [App\Http\Controllers\Contribution\ImportContributionSenasirController::class, 'import_create_or_update_contribution_period_senasir']);

            Route::post('/list_months_import_contribution_command', [App\Http\Controllers\Contribution\ImportContributionCommandController::class, 'list_months_import_contribution_command']);
            Route::post('/import_contribution_command', [App\Http\Controllers\Contribution\ImportContributionCommandController::class, 'import_contribution_command']);
        });
        Route::group([
            'middleware' => 'permission:download-report-senasir|download-report-command'
        ], function () {
            Route::post('/report_import_contribution_senasir', [App\Http\Controllers\Contribution\ImportContributionSenasirController::class, 'report_import_contribution_senasir']);
            Route::post('/report_import_contribution_command', [App\Http\Controllers\Contribution\ImportContributionCommandController::class, 'report_import_contribution_command']);
        });
        Route::post('/update_base_wages', [App\Http\Controllers\Contribution\ImportPayrollCommandController::class, 'update_base_wages']);
    });
});

