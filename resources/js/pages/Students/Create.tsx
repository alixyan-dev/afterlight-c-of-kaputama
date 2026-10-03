import { Head, useForm } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Link } from '@inertiajs/react';

export default function StudentsCreate() {
    const { data, setData, post, processing, errors } = useForm({
        user_id: '',
        npm: '',
        class_name: '',
        phone: '',
        status: 'active',
    });

    return (
        <>
            <Head title="Tambah Mahasiswa" />
            <div className="container mx-auto p-6 max-w-lg">
                <h1 className="text-2xl font-bold mb-6">Tambah Mahasiswa</h1>
                <Card>
                    <CardContent className="pt-6 space-y-4">
                        <form onSubmit={(e) => { e.preventDefault(); post('/students'); }}>
                            <div className="space-y-2">
                                <Label htmlFor="npm">NPM</Label>
                                <Input id="npm" value={data.npm} onChange={(v) => setData('npm', v.target.value)} placeholder="Contoh: 2023001" />
                                {errors.npm && <p className="text-sm text-red-500">{errors.npm}</p>}
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="user_id">User ID (UUID)</Label>
                                <Input id="user_id" value={data.user_id} onChange={(v) => setData('user_id', v.target.value)} placeholder="UUID pengguna" />
                                {errors.user_id && <p className="text-sm text-red-500">{errors.user_id}</p>}
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="class_name">Kelas</Label>
                                <Input id="class_name" value={data.class_name} onChange={(v) => setData('class_name', v.target.value)} placeholder="Contoh: C" />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="phone">Telepon</Label>
                                <Input id="phone" value={data.phone} onChange={(v) => setData('phone', v.target.value)} placeholder="Contoh: 0812..." />
                            </div>
                            <div className="flex gap-2 pt-4">
                                <Button type="submit" disabled={processing}>Simpan</Button>
                                <Link href={'/students'}><Button variant="outline">Batal</Button></Link>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
