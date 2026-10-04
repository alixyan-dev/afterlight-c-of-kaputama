import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

export default function SchedulePage({ semesters }: { semesters?: Array<{ id: string; name: string }> }) {
    const [filterSemester, setFilterSemester] = useState('');
    const [filterDay, setFilterDay] = useState('');

    return (
        <>
            <Head title="Jadwal Perkuliahan" />
            <div className="container mx-auto p-6">
                <h1 className="text-2xl font-bold mb-6">Jadwal Perkuliahan</h1>
                <div className="flex flex-col sm:flex-row gap-3 mb-4">
                    <select value={filterSemester} onChange={e => setFilterSemester(e.target.value)} className="w-full sm:w-48 rounded-md border px-3 py-2 text-sm bg-background">
                        <option value="">Semua Semester</option>
                        {semesters?.map((s: any) => <option key={s.id} value={s.id}>{s.name}</option>)}
                    </select>
                    <Input placeholder="Filter hari..." value={filterDay} onChange={e => setFilterDay(e.target.value)} className="w-full sm:max-w-xs" />
                    <Link href="/courses"><Button variant="outline">Lihat Mata Kuliah</Button></Link>
                </div>
                <Card>
                    <CardContent className="pt-6">
                        <p className="text-muted-foreground">Filter: Semester = {filterSemester || 'Semua'}, Hari = {filterDay || 'Semua'}</p>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
