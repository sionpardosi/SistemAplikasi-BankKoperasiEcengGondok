<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\OrderItem;
use App\Models\ReviewMedia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240', // 10MB limit
        ]);

        // Get the order item and check if it belongs to the authenticated user
        $orderItem = OrderItem::with('order')->findOrFail($request->order_item_id);

        // Pastikan folder ada
        $uploadPath = public_path('uploads/media_review_pengguna');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($orderItem->order->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengulas produk ini.');
        }

        // Check if the order is completed
        if ($orderItem->order->status !== 'completed') {
            return back()->with('error', 'Pesanan harus selesai sebelum Anda dapat memberikan ulasan.');
        }

        // Check if this order item has already been reviewed
        if ($orderItem->review) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        // Create the review
        $review = Review::create([
            'user_id' => Auth::id(),
            'order_item_id' => $request->order_item_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved', // Auto approve for now
        ]);

// Handle file uploads
if ($request->hasFile('media')) {
    foreach ($request->file('media') as $file) {
        // Determine file type SEBELUM file dipindahkan
        $fileType = strpos($file->getMimeType(), 'image') !== false ? 'image' : 'video';

        // Generate unique filename
        $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

        // Move to public/uploads/media_review_pengguna
        $file->move(public_path('uploads/media_review_pengguna'), $filename);

        // Save relative path for asset()
        $mediaPath = 'uploads/media_review_pengguna/' . $filename;

        // Create media record
        ReviewMedia::create([
            'review_id' => $review->id,
            'file_path' => $mediaPath,
            'file_type' => $fileType,
        ]);
    }
}

        return back()->with('status', 'Ulasan Anda berhasil dikirim. Terima kasih atas masukan Anda!');
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
        ]);

        // Get the review and check ownership
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah ulasan ini.');
        }

        // Update the review
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

// Handle file uploads
if ($request->hasFile('media')) {
    // Pastikan folder ada
    $uploadPath = public_path('uploads/media_review_pengguna');
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    foreach ($request->file('media') as $file) {
        // Determine file type SEBELUM file dipindahkan
        $fileType = strpos($file->getMimeType(), 'image') !== false ? 'image' : 'video';

        // Generate unique filename
        $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

        // Move to public/uploads/media_review_pengguna
        $file->move(public_path('uploads/media_review_pengguna'), $filename);

        // Save relative path for asset()
        $mediaPath = 'uploads/media_review_pengguna/' . $filename;

        // Create media record
        ReviewMedia::create([
            'review_id' => $review->id,
            'file_path' => $mediaPath,
            'file_type' => $fileType,
        ]);
    }
}

        return back()->with('status', 'Ulasan Anda berhasil diperbarui.');
    }

    public function deleteMedia($id)
    {
        $media = ReviewMedia::findOrFail($id);
        $review = $media->review;

        // Check ownership
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus media ini.');
        }

        // Delete file from public directory
        if (file_exists(public_path($media->file_path))) {
            unlink(public_path($media->file_path));
        }

        // Delete record
        $media->delete();

        return back()->with('status', 'Media ulasan berhasil dihapus.');
    }
}
