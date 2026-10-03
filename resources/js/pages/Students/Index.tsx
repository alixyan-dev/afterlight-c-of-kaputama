import { Head, Link } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { PageProps } from '@/types';

export default function StudentsIndex({ profiles }: PageProps) {
    return (
        <>
            <Head title="Data Mahasiswa" />
            <div className="container mx-auto p-6">
                <div className="flex justify-between items-center mb-6">
                    <h1 className="text-2xl font-bold">Data Mahasiswa</h1>
                    <Link href={route('students.create')}>
                        <Button>+ Tambah Mahasiswa</Button>
                    </Link>
                </div>
                <Card>
                    <CardHeader><CardTitle>Daftar Profil Mahasiswa</CardTitle></CardHeader>
                    <CardContent>
                        <table className="w-full text-sm">
                            <thead><tr><th>NPM</th><th>Nama User</th><th>Kelas</th><th>Telepon</th><th>Status</th><th>Aksi</th></tr></thead>
                            <tbody>
                                {profiles?.data?.map((p: any) => (
                                    <tr key={p.id} className="border-t">
                                        <td className="py-2 font-mono">{p.npm}</td>
                                        <td>{p.user?.name || '-'}</td>
                                        <td>{p.class_name || '-'}</td>
                                        <td>{p.phone || '-'}</td>
                                        <td>{p.status === 'active' ? 'Aktif' : 'Nonaktif'}</td>
                                        <td className="space-x-2">
                                            <Link href={route('students.edit', p.id)}><Button size="sm">Edit</Button></Link>
                                            <Link href={route('students.show', p.id)}><Button size="sm" variant="outline">Detail</Button></Link>
                                        </td>
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
