<?php

namespace App\Events;

use stdClass;
use App\Models\MenusModel;
use App\Models\AccessModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Permission;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreatePermissions
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event after migration ended.
     *
     * @return void
     */
    public function handle()
    {
        $lastMigration = DB::table('migrations')->orderBy('id', 'desc')->first();

        if ($lastMigration) {
            $json = file_get_contents(public_path('seeds/Menus.json'));
            $menus = json_decode($json, true);
            $actions = ['create', 'read', 'update', 'delete'];

            try {
                foreach ($menus as $menu) {
                    $permissionName = $menu['name'];
                    Permission::firstOrCreate(['name' => $permissionName]);

                    foreach ($actions as $action) {
                        $permissionNameAction = $permissionName . '-' . $action;
                        Permission::firstOrCreate(['name' => $permissionNameAction]);
                    }
                }
            } catch (\Exception $e) {
                // ENABLE IF WANT TO LOG ERROR
                // Log::error('Error creating permission: ' . $e->getMessage());
            }
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
