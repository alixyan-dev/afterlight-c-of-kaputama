import { Head, useForm } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Link } from '@inertiajs/react';

export default function StudentsEdit({ profile }: { profile: any }) {
    const { data, setData, put, processing, errors } = useForm({
        npm: profile.npm,
        class_name: profile.class_name || '',
        phone: profile.phone || '',
        status: profile.status,
    });

    return (
        <>
            <Head title="Edit Mahasiswa" />
            <div className="container mx-auto p-6 max-w-lg">
                <h1 className="text-2xl font-bold mb-6">Edit Mahasiswa</h1>
                <Card>
                    <CardContent className="pt-6 space-y-4">
                        <form onSubmit={(e) => { e.preventDefault(); put(route('students.update', profile.id)); }}>
                            <div className="space-y-2">
                                <Label htmlFor="npm">NPM</Label>
                                <Input id="npm" value={data.npm} onChange={(v) => setData('npm', v.target.value)} />
                                {errors.npm && <p className="text-sm text-red-500">{errors.npm}</p>}
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="class_name">Kelas</Label>
                                <Input id="class_name" value={data.class_name} onChange={(v) => setData('class_name', v.target.value)} />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="phone">Telepon</Label>
                                <Input id="phone" value={data.phone} onChange={(v) => setData('phone', v.target.value)} />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="status">Status</Label>
                                <select id="status" value={data.status} onChange={(v) => setData('status', v.target.value)} className="w-full rounded-md border px-3 py-2 text-sm">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>
                            <div className="flex gap-2 pt-4">
                                <Button type="submit" disabled={processing}>Simpan</Button>
                                <Link href={route('students.index')}><Button variant="outline">Batal</Button></Link>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
