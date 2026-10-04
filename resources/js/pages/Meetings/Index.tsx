import { Head, Link } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';

export default function MeetingsIndex({ meetings }: { meetings: any }) {
    return (<>
        <Head title="Pertemuan" />
        <div className="container mx-auto p-6">
            <div className="flex justify-between mb-6"><h1 className="text-2xl font-bold">Pertemuan</h1><Link href="/meetings/create"><Button>+ Buat Pertemuan</Button></Link></div>
            <Card><CardContent className="pt-6"><table className="w-full text-sm min-w-[640px]"><thead><tr className="border-b"><th className="py-3 px-4 text-left">Judul</th><th className="py-3 px-4">Tanggal</th><th className="py-3 px-4">Status</th><th className="py-3 px-4 text-right">Aksi</th></tr></thead>
            <tbody>{meetings?.data?.map((m: any) => (<tr key={m.id} className="border-b"><td className="py-3 px-4">{m.title}</td><td className="py-3 px-4">{m.meeting_date}</td><td className="py-3 px-4"><span className="text-xs uppercase">{m.status}</span></td><td className="py-3 px-4 text-right"><Link href={`/meetings/${m.id}/edit`}><Button size="sm" variant="outline">Edit</Button></Link></td></tr>))}</tbody></table></CardContent></Card>
        </div>
    </>);
}
