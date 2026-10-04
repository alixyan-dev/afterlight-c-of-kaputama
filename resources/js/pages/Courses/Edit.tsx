import { Head, Link, useForm } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

interface Semester { id: string; name: string; academic_year: string; }
interface Course { id: string; code: string; name: string; lecturer_name: string; day_of_week: string; start_time: string; end_time: string; room?: string; description?: string; is_active: boolean; semester_id?: string; }

export default function CoursesEdit({ course, semesters }: { course: Course; semesters?: Semester[] }) {
    const { data, setData, put, processing } = useForm({ code: course.code, name: course.name, lecturer_name: course.lecturer_name, day_of_week: course.day_of_week, start_time: course.start_time, end_time: course.end_time, room: course.room || '', description: course.description || '', is_active: course.is_active, semester_id: course.semester_id || '' });
    return (<>
        <Head title="Edit Mata Kuliah" />
        <div className="container mx-auto p-6 max-w-2xl">
            <h1 className="text-2xl font-bold mb-6">Edit Mata Kuliah</h1>
            <Card>
                <CardContent className="pt-6 space-y-4">
                    <form onSubmit={e => { e.preventDefault(); put(`/courses/${course.id}`); }} className="grid md:grid-cols-2 gap-4">
                        <div><Label>Kode</Label><Input value={data.code} onChange={e => setData('code', e.target.value)} /></div>
                        <div><Label>Nama</Label><Input value={data.name} onChange={e => setData('name', e.target.value)} /></div>
                        <div><Label>Dosen</Label><Input value={data.lecturer_name} onChange={e => setData('lecturer_name', e.target.value)} /></div>
                        <div>
                            <Label>Semester</Label>
                            <select value={data.semester_id} onChange={e => setData('semester_id', e.target.value)} className="w-full rounded-md border px-3 py-2 text-sm bg-background">
                                <option value="">Pilih Semester</option>
                                {semesters?.map((s: any) => <option key={s.id} value={s.id}>{s.name} — {s.academic_year}</option>)}
                            </select>
                        </div>
                        <div><Label>Hari</Label><Input value={data.day_of_week} onChange={e => setData('day_of_week', e.target.value)} /></div>
                        <div><Label>Mulai</Label><Input type="time" value={data.start_time} onChange={e => setData('start_time', e.target.value)} /></div>
                        <div><Label>Selesai</Label><Input type="time" value={data.end_time} onChange={e => setData('end_time', e.target.value)} /></div>
                        <div><Label>Ruangan</Label><Input value={data.room} onChange={e => setData('room', e.target.value)} /></div>
                        <div className="md:col-span-2">
                            <Button type="submit" disabled={processing}>Simpan</Button>
                            <Link href="/courses"><Button variant="outline" className="ml-2">Batal</Button></Link>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </>);
}
