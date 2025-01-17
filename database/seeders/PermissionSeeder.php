<?php

namespace Database\Seeders;

use App\Constants\Role;
use App\Models\Tenants\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('database.default') == 'tenant') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        User::get()->each(fn (User $user) => $this->assignRoleToUser($user));

        $permissions = $this->getPermissions();
        $permissions->each(fn ($roles, $index) => $this->savePermission($index, $roles));
        if (config('database.default') == 'tenant') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        User::first()->assignRole(Role::admin);
    }

    private function crudRolePermission(): array
    {
        return [
            [
                'role' => [Role::admin],
                'permissions' => [
                    'category' => [
                        'c', 'r', 'u', 'd',
                    ],
                    'product' => [
                        'c', 'r', 'u', 'd',
                    ],
                    'product stock' => [
                        'c', 'r', 'u', 'd',
                    ],
                    'member' => [
                        'c', 'r', 'u', 'd',
                    ],
                    'selling' => [
                        'c', 'r', 'u', 'd',
                    ],
                    'payment method' => [
                        'c', 'r', 'u', 'd',
                    ],
                    'cash drawer' => [
                        'open', 'r', 'close',
                    ],
                    'printer' => [
                        'c', 'r', 'u', 'd',
                    ],
                    'using setting enable secure initial price' => [
                        'r',
                    ],
                    'cashier report' => [
                        'generate',
                    ],
                    'selling report' => [
                        'generate',
                    ],
                    'product report' => [
                        'generate',
                    ],
                ],
            ],
        ];
    }

    private function normalizeCrudPermission()
    {
        $normalize = [];
        foreach ($this->crudRolePermission() as $permissions) {
            foreach ($permissions['permissions'] as $feature => $crud) {
                for ($i = 0; $i < count($crud); $i++) {
                    $action = '';
                    switch ($crud[$i]) {
                        case 'c':
                            $action = "create $feature";
                            break;
                        case 'r':
                            $action = "read $feature";
                            break;
                        case 'u':
                            $action = "update $feature";
                            break;
                        case 'd':
                            $action = "delete $feature";
                            break;
                        default:
                            $action = "$crud[$i] $feature";
                            break;
                    }
                    $normalize[$action] = $permissions['role'];
                }
            }
        }

        return $normalize;
    }

    private function getPermissions(): Collection
    {
        return collect(array_merge($this->normalizeCrudPermission(), [

        ]));
    }

    private function savePermission($index, $roles): void
    {
        $permission = Permission::firstOrCreate(['name' => $index]);

        collect($roles)->each(fn ($role) => $this->givePermissionToRole($role, $permission));
    }

    private function givePermissionToRole($role, $permission): void
    {
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $role]);
        $role->givePermissionTo($permission->name);
    }

    /**
     * @return void
     *
     * @throws InvalidArgumentException
     */
    private function assignRoleToUser(User $user)
    {
        $role = ModelsRole::inRandomOrder()->first();
        $user->syncRoles($role);
    }
}
