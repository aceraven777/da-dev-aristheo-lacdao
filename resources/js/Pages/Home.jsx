import { Head } from '@inertiajs/react';

export default function Home({ auth }) {
    return (
        <>
            <Head title="To-do List" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">This is it!</div>
                    </div>
                </div>
            </div>
        </>
    );
}
