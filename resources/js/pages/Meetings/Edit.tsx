import { Head, Link, useForm } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

interface M { id: string; title: string; meeting_date: string; start_time: string; end_time: string; status: string; }
export default function MeetingsEdit({ meeting }: { meeting: M }) {
    const { data, setData, put, processing } = useForm({ title: meeting.title, meeting_date: meeting.meeting_date, start_time: meeting.start_time, end_time: meeting.end_time, status: meeting.status });
    return (<><Head title="Edit Pertemuan" /><div className="container mx-auto p-6 max-w-lg"><h1 className="text-2xl font-bold mb-6">Edit Pertemuan</h1><Card><CardContent className="pt-6 space-y-4"><form onSubmit={e => { e.preventDefault(); put(`/meetings/${meeting.id}`); }}><div><Label>Judul</Label><Input value={data.title} onChange={e => setData('title', e.target.value)} /></div><div><Label>Tanggal</Label><Input type="date" value={data.meeting_date} onChange={e => setData('meeting_date', e.target.value)} /></div><div><Label>Mulai</Label><Input type="time" value={data.start_time} onChange={e => setData('start_time', e.target.value)} /></div><div><Label>Selesai</Label><Input type="time" value={data.end_time} onChange={e => setData('end_time', e.target.value)} /></div><div><Button type="submit" disabled={processing}>Simpan</Button><Link href="/meetings"><Button variant="outline" className="ml-2">Batal</Button></Link></div></form></CardContent></Card></div></>);
}
