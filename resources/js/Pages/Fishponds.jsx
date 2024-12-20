import { useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";

export default function Fishponds({ fishponds }) {
    const [isCreateModalOpen, setCreateModalOpen] = useState(false);
    const [isUpdateModalOpen, setUpdateModalOpen] = useState(false);
    const [selectedFishpond, setSelectedFishpond] = useState(null);

    const {
        data,
        setData,
        post,
        patch,
        destroy, // Include the destroy method for deleting items
        errors,
        processing,
        recentlySuccessful,
        reset,
    } = useForm({
        name: "",
        location: "",
    });

    const handleCreateModalToggle = () => {
        setCreateModalOpen(!isCreateModalOpen);
        reset();
    };

    const handleUpdateModalToggle = (fishpond = null) => {
        if (fishpond) {
            setSelectedFishpond(fishpond);
            setData({
                name: fishpond.name,
                location: fishpond.location,
            });
        } else {
            setSelectedFishpond(null);
            reset();
        }
        setUpdateModalOpen(!isUpdateModalOpen);
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setData(name, value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        if (selectedFishpond) {
            patch(route("fishponds.update", selectedFishpond.id), {
                onSuccess: () => {
                    handleUpdateModalToggle();
                },
            });
        } else {
            post(route("fishponds.store"), {
                onSuccess: () => {
                    handleCreateModalToggle();
                },
            });
        }
    };

    const handleDelete = (fishpondId) => {
        if (confirm("Are you sure you want to delete this fishpond?")) {
            destroy(route("fishponds.destroy", fishpondId), {
                onSuccess: () => {
                    // Optional: Refresh the page or update the state to reflect the deletion
                    alert("Fishpond deleted successfully.");
                },
                onError: () => {
                    alert("Failed to delete the fishpond.");
                },
            });
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Fish Ponds
                </h2>
            }
        >
            <Head title="Fish Ponds" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <button
                                onClick={handleCreateModalToggle}
                                className="mb-4 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200"
                            >
                                Add Fishpond
                            </button>

                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead className="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Location
                                            </th>
                                            <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        {fishponds?.map((fishpond) => (
                                            <tr key={fishpond.id}>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {fishpond.name}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {fishpond.location}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button
                                                        onClick={() =>
                                                            handleUpdateModalToggle(
                                                                fishpond
                                                            )
                                                        }
                                                        className="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg transition duration-200"
                                                    >
                                                        Edit
                                                    </button>
                                                    <button
                                                        onClick={() =>
                                                            handleDelete(
                                                                fishpond.id
                                                            )
                                                        }
                                                        className="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition duration-200 ml-2"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Create Modal */}
            {isCreateModalOpen && (
                <div className="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
                        <h3 className="text-lg font-semibold dark:text-white">
                            Create Fishpond
                        </h3>
                        <form onSubmit={handleSubmit}>
                            <label className="block mt-4">
                                <span className="text-gray-700 dark:text-gray-200">
                                    Name:
                                </span>
                                <input
                                    type="text"
                                    name="name"
                                    value={data.name}
                                    onChange={handleInputChange}
                                    className="w-full p-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required
                                />
                            </label>
                            <label className="block mt-4">
                                <span className="text-gray-700 dark:text-gray-200">
                                    Location:
                                </span>
                                <input
                                    type="text"
                                    name="location"
                                    value={data.location}
                                    onChange={handleInputChange}
                                    className="w-full p-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required
                                />
                            </label>
                            <div className="mt-6 flex justify-end space-x-3">
                                <button
                                    type="button"
                                    onClick={handleCreateModalToggle}
                                    className="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition duration-200"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200"
                                >
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Update Modal */}
            {isUpdateModalOpen && (
                <div className="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
                        <h3 className="text-lg font-semibold dark:text-white">
                            Edit Fishpond
                        </h3>
                        <form onSubmit={handleSubmit}>
                            <label className="block mt-4">
                                <span className="text-gray-700 dark:text-gray-200">
                                    Name:
                                </span>
                                <input
                                    type="text"
                                    name="name"
                                    value={data.name}
                                    onChange={handleInputChange}
                                    className="w-full p-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required
                                />
                            </label>
                            <label className="block mt-4">
                                <span className="text-gray-700 dark:text-gray-200">
                                    Location:
                                </span>
                                <input
                                    type="text"
                                    name="location"
                                    value={data.location}
                                    onChange={handleInputChange}
                                    className="w-full p-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required
                                />
                            </label>
                            <div className="mt-6 flex justify-end space-x-3">
                                <button
                                    type="button"
                                    onClick={() => handleUpdateModalToggle()}
                                    className="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition duration-200"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200"
                                >
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
