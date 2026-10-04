import { Input } from '@/components/ui/input';
import { Head, Link } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';

export default function CoursesIndex({ courses }: { courses: any }) {
    return (
        <>
            <Head title="Mata Kuliah" />
            <div className="container mx-auto p-6">
                <div className="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
                    <h1 className="text-2xl font-bold">Mata Kuliah</h1>
                    <Link href="/courses/create"><Button>+ Tambah Mata Kuliah</Button></Link>
                </div>
                <div className="flex flex-col sm:flex-row gap-3 mb-4">
                    <Input placeholder="Cari kode / nama..." className="w-full sm:max-w-xs" />
                    <select className="w-full sm:w-40 rounded-md border px-3 py-2 text-sm bg-background"><option>Semua Semester</option><option>Aktif</option><option>Nonaktif</option></select>
                </div>

                <Card>
                    <CardContent className="pt-6">
                        <div className="overflow-x-auto rounded-md border border-border/50">
                            <table className="w-full text-sm min-w-[720px]">
                                <thead><tr className="border-b bg-muted/50"><th className="py-3 px-4 text-left">Kode</th><th className="py-3 px-4 text-left">Nama</th><th className="py-3 px-4 text-left">Dosen</th><th className="py-3 px-4 text-left">Hari</th><th className="py-3 px-4 text-left">Waktu</th><th className="py-3 px-4 text-right">Aksi</th></tr></thead>
                                <tbody>{courses?.data?.map((c: any) => (<tr key={c.id} className="border-b"><td className="py-3 px-4 font-mono text-xs">{c.code}</td><td className="py-3 px-4">{c.name}</td><td className="py-3 px-4 text-muted-foreground">{c.lecturer_name}</td><td className="py-3 px-4">{c.day_of_week}</td><td className="py-3 px-4 text-muted-foreground">{c.start_time?.slice(0,5)} - {c.end_time?.slice(0,5)}</td><td className="py-3 px-4 text-right"><Link href={`/courses/${c.id}/edit`}><Button size="sm" variant="outline">Edit</Button></Link></td></tr>))}</tbody>
                            </table>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
