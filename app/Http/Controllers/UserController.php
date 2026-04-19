<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user.
     */
    public function index()
    {
        $pendingUsers = User::where('is_approved', false)->orderBy('created_at', 'desc')->get();
        $approvedUsers = User::where('is_approved', true)->orderBy('created_at', 'desc')->paginate(15);

        return view('users.index', compact('pendingUsers', 'approvedUsers'));
    }

    /**
     * Setujui user.
     */
    public function approve(User $user)
    {
        $user->update(['is_approved' => true]);

        return redirect()->route('users.index')
            ->with('success', "User \"{$user->name}\" berhasil disetujui.");
    }

    /**
     * Tolak user (hapus akun).
     */
    public function reject(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak bisa menolak akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "User \"{$name}\" berhasil ditolak dan dihapus.");
    }

    /**
     * Hapus user tertentu.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "User \"{$user->name}\" berhasil dihapus.");
    }
}
