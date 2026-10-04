import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Pencil, Trash2 } from 'lucide-react';

interface Semester {
    id: string;
    name: string;
    academic_year: string;
    start_date: string;
    end_date: string;
    is_active: boolean;
}

interface Props {
    semesters: { data: Semester[]; current_page: number; last_page: number };
}

export default function SemestersIndex({ semesters }: Props) {
    const [deleteId, setDeleteId] = useState<string | null>(null);

    function handleDelete(id: string) {
        router.delete(`/semesters/${id}`);
        setDeleteId(null);
    }

    return (
        <>
            <Head title="Semester" />
            <div className="container mx-auto p-6">
                <div className="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
                    <h1 className="text-2xl font-bold">Semester</h1>
                    <Link href="/semesters/create">
                        <Button className="w-full md:w-auto">+ Tambah Semester</Button>
                    </Link>
                </div>

                <Card>
                    <CardContent className="pt-6">
                        <div className="overflow-x-auto rounded-md border border-border/50">
                            <table className="w-full text-sm min-w-[480px]">
                                <thead>
                                    <tr className="border-b">
                                        <th className="py-3 px-4 text-left font-medium">Nama</th>
                                        <th className="py-3 px-4 text-left font-medium">Tahun Akademik</th>
                                        <th className="py-3 px-4 text-left font-medium">Mulai</th>
                                        <th className="py-3 px-4 text-left font-medium">Selesai</th>
                                        <th className="py-3 px-4 text-left font-medium">Status</th>
                                        <th className="py-3 px-4 text-right font-medium">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {semesters?.data?.map((s: Semester) => (
                                        <tr key={s.id} className="border-b last:border-0">
                                            <td className="py-3 px-4 font-medium">{s.name}</td>
                                            <td className="py-3 px-4 text-muted-foreground">{s.academic_year}</td>
                                            <td className="py-3 px-4 text-muted-foreground">{s.start_date}</td>
                                            <td className="py-3 px-4 text-muted-foreground">{s.end_date}</td>
                                            <td className="py-3 px-4">
                                                <Badge variant={s.is_active ? 'default' : 'secondary'}>
                                                    {s.is_active ? 'Aktif' : 'Nonaktif'}
                                                </Badge>
                                            </td>
                                            <td className="py-3 px-4">
                                                <div className="flex justify-end gap-2">
                                                    <Link href={`/semesters/${s.id}/edit`}>
                                                        <Button size="sm" variant="outline"><Pencil className="size-3.5" /> Edit</Button>
                                                    </Link>
                                                    <Button size="sm" variant="destructive" onClick={() => setDeleteId(s.id)}>
                                                        <Trash2 className="size-3.5" /> Hapus
                                                    </Button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                    {!semesters?.data?.length && (
                                        <tr><td colSpan={6} className="py-8 text-center text-muted-foreground">Tidak ada semester</td></tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
