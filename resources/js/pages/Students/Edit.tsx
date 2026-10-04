import { Head, Link, useForm } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

interface Student {
    id: string;
    name: string;
    email: string;
    is_active: boolean;
}

export default function StudentsEdit({ student }: { student: Student }) {
    const { data, setData, put, processing, errors } = useForm({
        name: student.name,
        email: student.email,
        is_active: student.is_active,
    });

    return (
        <>
            <Head title="Edit Mahasiswa" />
            <div className="container mx-auto p-6 max-w-lg">
                <h1 className="text-2xl font-bold mb-6">Edit Mahasiswa</h1>
                <Card>
                    <CardContent className="pt-6">
                        <form
                            onSubmit={(e) => {
                                e.preventDefault();
                                put(`/students/${student.id}`);
                            }}
                            className="space-y-4"
                        >
                            <div className="space-y-2">
                                <Label htmlFor="name">Nama</Label>
                                <Input
                                    id="name"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                />
                                {errors.name && (
                                    <p className="text-sm text-red-500">{errors.name}</p>
                                )}
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="email">Email</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                />
                                {errors.email && (
                                    <p className="text-sm text-red-500">{errors.email}</p>
                                )}
                            </div>
                            <div className="space-y-2">
                                <Label>Status</Label>
                                <Select
                                    value={String(data.is_active)}
                                    onValueChange={(value) =>
                                        setData('is_active', value === 'true')
                                    }
                                >
                                    <SelectTrigger>
                                        <SelectValue placeholder="Status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="true">Aktif</SelectItem>
                                        <SelectItem value="false">Nonaktif</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            <div className="flex gap-2 pt-4">
                                <Button type="submit" disabled={processing}>
                                    Simpan
                                </Button>
                                <Link href="/students">
                                    <Button variant="outline">Batal</Button>
                                </Link>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
