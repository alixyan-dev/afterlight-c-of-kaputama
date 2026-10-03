import { Head, useForm, usePage } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Link } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function RoleManagement() {
    const { users, roles, auth } = usePage<PageProps>().props;
    const { data, setData, post, processing, reset } = useForm({ role_name: '', user_id: '' });

    return (
        <>
            <Head title="Manajemen Role — Komting" />
            <div className="container mx-auto p-6">
                <h1 className="text-2xl font-bold mb-6">Manajemen Role (Komting)</h1>

                <Card className="mb-6">
                    <CardHeader><CardTitle>Assign Role</CardTitle></CardHeader>
                    <CardContent>
                        <form onSubmit={(e) => { e.preventDefault(); post(route('users.roles.assign', data.user_id), { onSuccess: () => reset() }); }} className="flex gap-3 items-end">
                            <div className="flex-1">
                                <Label htmlFor="user_id">User ID (UUID)</Label>
                                <Input id="user_id" value={data.user_id} onChange={(v) => setData('user_id', v.target.value)} placeholder="01a0fb10-..." />
                            </div>
                            <div className="flex-1">
                                <Label htmlFor="role_name">Role</Label>
                                <Input id="role_name" value={data.role_name} onChange={(v) => setData('role_name', v.target.value)} placeholder="mahasiswa / komting / ..." />
                            </div>
                            <Button type="submit" disabled={processing}>Assign</Button>
                        </form>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader><CardTitle>Daftar User</CardTitle></CardHeader>
                    <CardContent>
                        <table className="w-full text-sm">
                            <thead><tr><th>User</th><th>ID (UUID)</th><th>Role</th><th>Aktif</th></tr></thead>
                            <tbody>
                                {users?.data?.map((u: any) => (
                                    <tr key={u.id} className="border-t">
                                        <td className="py-2">{u.name}</td>
                                        <td className="font-mono text-xs">{u.id}</td>
                                        <td>{Array.isArray(u.roles) ? u.roles.map((r: any) => r.name).join(', ') : '-'}</td>
                                        <td>{u.is_active ? 'Ya' : 'Tidak'}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
