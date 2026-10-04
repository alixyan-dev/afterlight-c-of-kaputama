import { Head } from '@inertiajs/react';
interface M { id: string; title: string; meeting_date: string; status: string; }
export default function MeetingsShow({ meeting }: { meeting: M }) {
    return (<><Head title="Detail Pertemuan" /><div className="container mx-auto p-6"><h1 className="text-2xl font-bold">{meeting.title}</h1><p>Tanggal: {meeting.meeting_date}</p><p>Status: {meeting.status}</p></div></>);
}
