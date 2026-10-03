import { Head, useForm, usePage } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
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
                        <form onSubmit={(e) => { e.preventDefault(); post('/users/' + data.user_id + '/role', { onSuccess: () => reset() }); }} className="flex gap-3 items-end">
                            <div className="flex-1">
                                <Label htmlFor="user_id">Pilih User</Label>
                                <Select value={data.user_id} onValueChange={(v) => setData('user_id', v)}>
                                    <SelectTrigger id="user_id" className="w-full">
                                        <SelectValue placeholder="Pilih mahasiswa..." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {users?.data?.map((u: any) => (
                                            <SelectItem key={u.id} value={u.id}>{u.name} ({u.id.substring(0, 8)}...)</SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </div>
                            <div className="flex-1">
                                <Label htmlFor="role_name">Role</Label>
                                <Select value={data.role_name} onValueChange={(v) => setData('role_name', v)}>
                                    <SelectTrigger id="role_name" className="w-full">
                                        <SelectValue placeholder="Pilih role..." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {roles?.map((r: any) => (
                                            <SelectItem key={r.id} value={r.name}>{r.name}</SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
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
