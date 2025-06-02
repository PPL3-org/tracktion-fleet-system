<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Table extends Component
{
    use WithPagination;

    public string $search = '';
    public int $itemsPerPage = 10;

    // Listener untuk me-refresh data jika ada user yang dihapus
    protected $listeners = ['userDeleted' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingItemsPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $currentUserId = Auth::id();

        $usersQuery = User::where('users.id', '!=', $currentUserId) // Jangan tampilkan diri sendiri
            ->leftJoinSub(
                DB::table('sessions')
                    ->select('user_id', DB::raw('MAX(last_activity) as last_seen_timestamp'))
                    ->whereNotNull('user_id')
                    ->groupBy('user_id'),
                'session_activity',
                'users.id', '=', 'session_activity.user_id'
            )
            ->select('users.*', 'session_activity.last_seen_timestamp')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('users.name', 'like', '%' . $this->search . '%')
                      ->orWhere('users.email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('users.name', 'asc');

        $users = $usersQuery->paginate($this->itemsPerPage)->through(function ($user) {
            if ($user->last_seen_timestamp) {
                $user->last_seen_formatted = Carbon::createFromTimestamp($user->last_seen_timestamp)
                                                    ->locale('id')
                                                    ->diffForHumans();
            } else {
                $user->last_seen_formatted = 'Belum Pernah / N/A';
            }
            return $user;
        });
        
        return view('livewire.admin.users.table', [
            'users' => $users,
        ]);
    }

    public function triggerDelete(int $userId)
    {
        $user = User::find($userId);
        if ($user) {
            // Mengirim event ke parent component (Index.php) untuk menampilkan modal konfirmasi
            $this->dispatch('confirmUserDeletion', user: $user)->to(Index::class);
        }
    }
}