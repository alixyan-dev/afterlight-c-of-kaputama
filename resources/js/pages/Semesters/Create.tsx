import { Head, Link, useForm } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

export default function SemestersCreate() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        academic_year: '',
        start_date: '',
        end_date: '',
        is_active: true,
    });

    return (
        <>
            <Head title="Tambah Semester" />
            <div className="container mx-auto p-6 max-w-lg">
                <h1 className="text-2xl font-bold mb-6">Tambah Semester</h1>
                <Card>
                    <CardContent className="pt-6 space-y-4">
                        <form onSubmit={(e) => { e.preventDefault(); post('/semesters'); }}>
                            <div className="space-y-2"><Label htmlFor="name">Nama</Label><Input id="name" value={data.name} onChange={e => setData('name', e.target.value)} /></div>
                            <div className="space-y-2"><Label htmlFor="academic_year">Tahun Akademik</Label><Input id="academic_year" value={data.academic_year} onChange={e => setData('academic_year', e.target.value)} /></div>
                            <div className="space-y-2"><Label htmlFor="start_date">Tanggal Mulai</Label><Input type="date" id="start_date" value={data.start_date} onChange={e => setData('start_date', e.target.value)} /></div>
                            <div className="space-y-2"><Label htmlFor="end_date">Tanggal Selesai</Label><Input type="date" id="end_date" value={data.end_date} onChange={e => setData('end_date', e.target.value)} /></div>
                            <div className="flex gap-2 pt-4">
                                <Button type="submit" disabled={processing}>Simpan</Button>
                                <Link href="/semesters"><Button variant="outline">Batal</Button></Link>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
