import { Head, Link, useForm } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

interface Semester { id: string; name: string; academic_year: string; start_date: string; end_date: string; is_active: boolean; }

export default function SemestersEdit({ semester }: { semester: Semester }) {
    const { data, setData, put, processing, errors } = useForm({ name: semester.name, academic_year: semester.academic_year, start_date: semester.start_date, end_date: semester.end_date, is_active: semester.is_active });
    return (
        <>
            <Head title="Edit Semester" />
            <div className="container mx-auto p-6 max-w-lg">
                <h1 className="text-2xl font-bold mb-6">Edit Semester</h1>
                <Card>
                    <CardContent className="pt-6 space-y-4">
                        <form onSubmit={(e) => { e.preventDefault(); put(`/semesters/${semester.id}`); }}>
                            <div className="space-y-2"><Label>Nama</Label><Input value={data.name} onChange={e => setData('name', e.target.value)} /></div>
                            <div className="space-y-2"><Label>Tahun Akademik</Label><Input value={data.academic_year} onChange={e => setData('academic_year', e.target.value)} /></div>
                            <div className="space-y-2"><Label>Tanggal Mulai</Label><Input type="date" value={data.start_date} onChange={e => setData('start_date', e.target.value)} /></div>
                            <div className="space-y-2"><Label>Tanggal Selesai</Label><Input type="date" value={data.end_date} onChange={e => setData('end_date', e.target.value)} /></div>
                            <div className="flex gap-2 pt-4"><Button type="submit" disabled={processing}>Simpan</Button><Link href="/semesters"><Button variant="outline">Batal</Button></Link></div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
