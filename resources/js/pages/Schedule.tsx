import { Head } from '@inertiajs/react';

export default function SchedulePage() {
    return (
        <>
            <Head title="Jadwal Perkuliahan" />
            <div className="container mx-auto p-6">
                <h1 className="text-2xl font-bold mb-6">Jadwal Perkuliahan</h1>
                <p className="text-muted-foreground">Halaman jadwal akan menampilkan filter per semester dan hari.</p>
            </div>
        </>
    );
}
