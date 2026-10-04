import { Head, Link, useForm } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

export default function MeetingsCreate({ courses, semesters }: { courses?: Array<{id:string;name:string}>, semesters?: Array<{id:string;name:string}> }) {
    const { data, setData, post, processing } = useForm({ course_id: '', semester_id: '', title: '', meeting_date: '', start_time: '', end_time: '', status: 'draft' });
    return (<><Head title="Buat Pertemuan" /><div className="container mx-auto p-6 max-w-lg"><h1 className="text-2xl font-bold mb-6">Buat Pertemuan</h1><Card><CardContent className="pt-6 space-y-4"><form onSubmit={e => { e.preventDefault(); post('/meetings'); }}><div>
                                <Label>Course</Label>
                                <select value={data.course_id} onChange={e => setData('course_id', e.target.value)} className="w-full rounded-md border px-3 py-2 text-sm bg-background"><option value="">Pilih Course</option>{courses?.map((c: any) => <option key={c.id} value={c.id}>{c.name}</option>)}</select>
                            </div>
                            <div>
                                <Label>Semester</Label>
                                <select value={data.semester_id} onChange={e => setData('semester_id', e.target.value)} className="w-full rounded-md border px-3 py-2 text-sm bg-background"><option value="">Pilih Semester</option>{semesters?.map((s: any) => <option key={s.id} value={s.id}>{s.name}</option>)}</select>
                            </div>
                        <div><Label>Judul</Label><Input value={data.title} onChange={e => setData('title', e.target.value)} /></div><div><Label>Tanggal</Label><Input type="date" value={data.meeting_date} onChange={e => setData('meeting_date', e.target.value)} /></div><div><Label>Mulai</Label><Input type="time" value={data.start_time} onChange={e => setData('start_time', e.target.value)} /></div><div><Label>Selesai</Label><Input type="time" value={data.end_time} onChange={e => setData('end_time', e.target.value)} /></div><div><Button type="submit" disabled={processing}>Simpan</Button><Link href="/meetings" className="ml-2"><Button variant="outline" type="button">Batal</Button></Link></div></form></CardContent></Card></div></>);
}
