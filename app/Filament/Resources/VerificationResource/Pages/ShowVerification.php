<?php

namespace App\Filament\Resources\VerificationResource\Pages;

use App\Filament\Resources\VerificationResource;
use App\Models\Verification;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ShowVerification extends ViewRecord
{
    protected static string $resource = VerificationResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            Actions\Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    return $this->downloadVerificationPdf();
                }),
        ];
        if ($this->record->user->shop->status == '0') {
            $actions[] = Actions\Action::make('approveVerification')
                ->label('Approve Verification')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Verification')
                ->modalDescription('Are you sure you want to approve this verification? This action will activate the user\'s account.')
                ->visible(fn () => $this->record->user->shop->status !== '0')
                ->action(function () {          
                    // Update user's shop status if exists
                    if ($this->record->user && $this->record->user->shop) {
                        $this->record->user->shop->update(['status' => 1]);
                    }
                    
                    $this->refreshFormData(['status', 'approved_at', 'approved_by']);
                });
        } else {
            $actions[] = Actions\Action::make('rejectVerification')
                ->label('Reject Verification')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Reject Verification')
                ->modalDescription('Are you sure you want to reject this verification? Please provide a reason.')
                ->action(function (array $data) {
                    if ($this->record->user && $this->record->user->shop) {
                        $this->record->user->shop->update(['status' => 0]);
                    }
                    
                    $this->refreshFormData(['status', 'rejected_at', 'rejected_by', 'rejection_reason']);
                });
        }

        $actions[] = Actions\EditAction::make()
            ->color('warning');
        
        $actions[] = Actions\DeleteAction::make()
            ->color('danger');

        return $actions;
    }

    protected function downloadVerificationPdf()
    {
        $verification = $this->record;
        
        // Load user with shop and related data
        $user = $verification->user()->with([
            'shop.products' => function($query) {
                $query->select('id', 'shop_id', 'name', 'status', 'created_at');
            },
            'shop.orders' => function($query) {
                $query->select('id', 'shop_id', 'created_at');
            },
            'bankAccounts' => function($query) {
                $query->where('status', 'active');
            }
        ])->first();
        
        // Set PDF options for better rendering
        $pdf = Pdf::loadView('pdf.verification-report', [
            'verification' => $verification,
            'user' => $user,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait')
          ->setOptions([
              'dpi' => 150,
              'defaultFont' => 'DejaVu Sans',
              'isRemoteEnabled' => true,
              'isHtml5ParserEnabled' => true,
          ]);
        
        $filename = "verification-report-VER" . str_pad($verification->id, 6, '0', STR_PAD_LEFT) . "-" . now()->format('Y-m-d') . ".pdf";
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}
