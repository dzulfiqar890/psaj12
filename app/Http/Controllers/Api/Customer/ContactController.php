<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Controller untuk customer mengirim pesan
 */
class ContactController extends Controller
{
    /**
     * @OA\Post(
     *     path="/contacts",
     *     tags={"Contacts"},
     *     summary="Kirim pesan ke admin",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"subject", "message"},
     *             @OA\Property(property="subject", type="string", example="Pertanyaan tentang produk"),
     *             @OA\Property(property="message", type="string", example="Apakah gitar ini tersedia dalam warna lain?")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Pesan berhasil dikirim"),
     *     @OA\Response(response=401, description="Belum login"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(ContactRequest $request): JsonResponse
    {
        $contact = Contact::create([
            'user_id' => $request->user()->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        Log::info("Contact message sent", [
            'user_id' => $request->user()->id,
            'contact_id' => $contact->id,
        ]);

        return ApiResponse::created($contact, 'Pesan berhasil dikirim. Kami akan segera menghubungi Anda.');
    }

    /**
     * @OA\Get(
     *     path="/my-contacts",
     *     tags={"Contacts"},
     *     summary="List pesan saya",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function myContacts(Request $request): JsonResponse
    {
        $contacts = Contact::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(12);

        return ApiResponse::paginated($contacts, 'Data pesan berhasil diambil.');
    }
}
