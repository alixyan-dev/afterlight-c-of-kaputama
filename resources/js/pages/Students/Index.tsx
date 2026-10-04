import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent } from '@/components/ui/card';
import { Copy, KeyRound, Pencil, Trash2 } from 'lucide-react';

interface Student {
    id: string;
    name: string;
    email: string;
    is_active: boolean;
    created_at: string;
}

interface PaginationData {
    data: Student[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    users: PaginationData;
    search: string | null;
    status: string | null;
    sort: string;
    direction: string;
    reset_password: string | null;
    reset_student_name: string | null;
}

export default function StudentsIndex({
    users,
    search,
    status,
    sort,
    direction,
    reset_password,
    reset_student_name,
}: Props) {
    const [searchInput, setSearchInput] = useState(search ?? '');
    const [deleteTarget, setDeleteTarget] = useState<Student | null>(null);
    const [copied, setCopied] = useState(false);

    function buildParams(overrides: Record<string, string | null> = {}) {
        const params: Record<string, string> = {};
        const s = overrides.search !== undefined ? overrides.search : search;
        const st = overrides.status !== undefined ? overrides.status : status;
        const sortVal = overrides.sort !== undefined ? overrides.sort : sort;
        const dirVal = overrides.direction !== undefined ? overrides.direction : direction;

        if (s) params.search = s;
        if (st && st !== 'all') params.status = st;
        if (sortVal) params.sort = sortVal;
        if (dirVal) params.direction = dirVal;

        return params;
    }

    function handleSearch(e: React.KeyboardEvent<HTMLInputElement>) {
        if (e.key === 'Enter') {
            router.get('/students', buildParams({ search: searchInput || null }), {
                preserveState: true,
                replace: true,
            });
        }
    }

    function handleStatusChange(value: string) {
        router.get(
            '/students',
            buildParams({ status: value === 'all' ? null : value }),
            { preserveState: true, replace: true },
        );
    }

    function handleSort(column: string) {
        const newDirection = sort === column && direction === 'asc' ? 'desc' : 'asc';
        router.get(
            '/students',
            buildParams({ sort: column, direction: newDirection }),
            { preserveState: true, replace: true },
        );
    }

    function handleResetPassword(student: Student) {
        router.post(`/students/${student.id}/reset-password`, {}, { preserveScroll: true });
    }

    function handleDelete() {
        if (!deleteTarget) return;
        router.delete(`/students/${deleteTarget.id}`, { preserveScroll: true });
        setDeleteTarget(null);
    }

    function handleCopyPassword() {
        if (reset_password) {
            navigator.clipboard.writeText(reset_password);
            setCopied(true);
            setTimeout(() => setCopied(false), 2000);
        }
    }

    function goPage(page: number) {
        const params = buildParams();
        params.page = String(page);
        router.get('/students', params, { preserveState: true });
    }

    function SortIcon({ column }: { column: string }) {
        if (sort !== column) {
            return <span className="ml-1 text-muted-foreground/50 select-none">↕</span>;
        }
        return (
            <span className="ml-1 text-foreground select-none">
                {direction === 'asc' ? '↑' : '↓'}
            </span>
        );
    }

    function formatDate(dateString: string) {
        return new Date(dateString).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        });
    }

    return (
        <>
            <Head title="Data Mahasiswa" />
            <div className="container mx-auto p-6">
                {/* Header */}
                <div className="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
                    <h1 className="text-2xl font-bold">Data Mahasiswa</h1>
                    <Link href="/students/create">
                        <Button className="w-full md:w-auto">+ Tambah Mahasiswa</Button>
                    </Link>
                </div>

                {/* Filters */}
                <div className="flex flex-col sm:flex-row gap-3 mb-4">
                    <Input
                        placeholder="Cari nama / email..."
                        value={searchInput}
                        onChange={(e) => setSearchInput(e.target.value)}
                        onKeyDown={handleSearch}
                        className="w-full sm:max-w-xs"
                    />
                    <Select
                        value={status ?? 'all'}
                        onValueChange={handleStatusChange}
                    >
                        <SelectTrigger className="w-full sm:w-40">
                            <SelectValue placeholder="Status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Semua</SelectItem>
                            <SelectItem value="active">Aktif</SelectItem>
                            <SelectItem value="inactive">Nonaktif</SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                {/* Table */}
                <Card>
                    <CardContent className="pt-6">
                        <div className="overflow-x-auto rounded-md border border-border/50">
                        <table className="w-full text-sm min-w-[640px]">
                            <thead>
                                <tr className="border-b">
                                    <th
                                        className="py-3 text-left font-medium cursor-pointer select-none hover:text-foreground/70 transition-colors"
                                        onClick={() => handleSort('name')}
                                    >
                                        Nama <SortIcon column="name" />
                                    </th>
                                    <th
                                        className="py-3 text-left font-medium cursor-pointer select-none hover:text-foreground/70 transition-colors"
                                        onClick={() => handleSort('email')}
                                    >
                                        Email <SortIcon column="email" />
                                    </th>
                                    <th
                                        className="py-3 text-left font-medium cursor-pointer select-none hover:text-foreground/70 transition-colors"
                                        onClick={() => handleSort('is_active')}
                                    >
                                        Status <SortIcon column="is_active" />
                                    </th>
                                    <th
                                        className="py-3 text-left font-medium cursor-pointer select-none hover:text-foreground/70 transition-colors"
                                        onClick={() => handleSort('created_at')}
                                    >
                                        Dibuat <SortIcon column="created_at" />
                                    </th>
                                    <th className="py-3 text-right font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {users?.data?.map((user) => (
                                    <tr key={user.id} className="border-b last:border-0">
                                        <td className="py-3">{user.name}</td>
                                        <td className="py-3 text-muted-foreground">{user.email}</td>
                                        <td className="py-3">
                                            <Badge
                                                variant={user.is_active ? 'default' : 'secondary'}
                                            >
                                                {user.is_active ? 'Aktif' : 'Nonaktif'}
                                            </Badge>
                                        </td>
                                        <td className="py-3 text-muted-foreground">
                                            {formatDate(user.created_at)}
                                        </td>
                                        <td className="py-3">
                                            <div className="flex justify-end gap-2">
                                                <Link href={`/students/${user.id}/edit`}>
                                                    <Button size="sm" variant="outline" className="hidden sm:inline-flex gap-1.5">
                                                        <Pencil className="size-3.5" />
                                                        <span className="hidden md:inline">Edit</span>
                                                    </Button>
                                                </Link>
                                                <Button
                                                    size="sm"
                                                    variant="destructive"
                                                    onClick={() => setDeleteTarget(user)}
                                                    className="hidden sm:inline-flex gap-1.5"
                                                >
                                                    <Trash2 className="size-3.5" />
                                                    <span className="hidden md:inline">Hapus</span>
                                                </Button>
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                    onClick={() => handleResetPassword(user)}
                                                    className="hidden sm:inline-flex gap-1.5"
                                                >
                                                    <KeyRound className="size-3.5" />
                                                    <span className="hidden md:inline">Reset</span>
                                                </Button>
                                                {/* Mobile icon-only buttons */}
                                                <div className="flex gap-1 sm:hidden">
                                                    <Link href={`/students/${user.id}/edit`}>
                                                        <Button size="icon" variant="outline" className="h-8 w-8">
                                                            <Pencil className="size-3.5" />
                                                        </Button>
                                                    </Link>
                                                    <Button size="icon" variant="destructive" className="h-8 w-8" onClick={() => setDeleteTarget(user)}>
                                                        <Trash2 className="size-3.5" />
                                                    </Button>
                                                    <Button size="icon" variant="outline" className="h-8 w-8" onClick={() => handleResetPassword(user)}>
                                                        <KeyRound className="size-3.5" />
                                                    </Button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                                {users?.data?.length === 0 && (
                                    <tr>
                                        <td
                                            colSpan={5}
                                            className="py-8 text-center text-muted-foreground"
                                        >
                                            Tidak ada data mahasiswa
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>

                        {/* Pagination */}
                        {users && users.last_page > 1 && (
                            <div className="flex items-center justify-between mt-4 text-sm">
                                <span className="text-xs md:text-sm text-muted-foreground hidden sm:inline">
                                    {users.current_page} / {users.last_page}
                                </span>
                                <div className="flex gap-2">
                                    <Button
                                        size="sm"
                                        variant="outline"
                                        disabled={users.current_page <= 1}
                                        onClick={() => goPage(users.current_page - 1)}
                                        className="text-xs"
                                    >
                                        ←
                                    </Button>
                                    <Button
                                        size="sm"
                                        variant="outline"
                                        disabled={users.current_page >= users.last_page}
                                        onClick={() => goPage(users.current_page + 1)}
                                        className="text-xs"
                                    >
                                        →
                                    </Button>
                                </div>
                            </div>
                        )}
                        </div>
                    </CardContent>
                </Card>

                {/* Delete Confirmation Dialog */}
                <Dialog
                    open={!!deleteTarget}
                    onOpenChange={(open) => !open && setDeleteTarget(null)}
                >
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Konfirmasi Hapus</DialogTitle>
                            <DialogDescription>
                                Yakin ingin menghapus akun{' '}
                                <strong>{deleteTarget?.name}</strong>? Tindakan ini tidak
                                dapat dibatalkan.
                            </DialogDescription>
                        </DialogHeader>
                        <DialogFooter>
                            <Button variant="outline" onClick={() => setDeleteTarget(null)}>
                                Batal
                            </Button>
                            <Button variant="destructive" onClick={handleDelete}>
                                Hapus
                            </Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>

                {/* Reset Password Modal */}
                {reset_password && (
                    <Dialog open onOpenChange={() => router.reload()}>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Password Baru</DialogTitle>
                                <DialogDescription>
                                    Password baru untuk{' '}
                                    <strong>{reset_student_name}</strong>:
                                </DialogDescription>
                            </DialogHeader>
                            <div className="flex items-center gap-2 p-3 rounded-md bg-muted">
                                <code className="flex-1 text-lg font-mono tracking-wider select-all">
                                    {reset_password}
                                </code>
                                <Button size="sm" variant="outline" onClick={handleCopyPassword}>
                                    {copied ? (
                                        '✓ Disalin'
                                    ) : (
                                        <>
                                            <Copy className="size-4" />
                                            Salin
                                        </>
                                    )}
                                </Button>
                            </div>
                            <p className="text-xs text-muted-foreground">
                                ⚠️ Catat password ini karena tidak dapat dilihat lagi.
                            </p>
                            <DialogFooter>
                                <Button onClick={() => router.reload()}>Tutup</Button>
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>
                )}
            </div>
        </>
    );
}
