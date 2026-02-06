<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Controller untuk manajemen kontak/pesan (Admin only)
 */
class ContactController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $contacts = Contact::with('user')
            ->byStatus($request->input('status'))
            ->latest()
            ->paginate(12);

        return ApiResponse::paginated($contacts, 'Data pesan berhasil diambil.');
    }

    public function show(Contact $contact): JsonResponse
    {
        $contact->load('user');

        // Auto mark as read jika masih pending
        if ($contact->isPending()) {
            $contact->markAsRead();
        }

        return ApiResponse::success($contact);
    }

    public function update(Request $request, Contact $contact): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,read,replied',
        ], [
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus pending, read, atau replied.',
        ]);

        $contact->update(['status' => $request->status]);

        Log::info("Contact status updated to: {$contact->status}", [
            'user_id' => auth()->id(),
            'contact_id' => $contact->id,
            'action' => 'update_status',
        ]);

        return ApiResponse::success($contact, 'Status pesan berhasil diupdate.');
    }
}
