import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { FaTemperatureHigh } from "react-icons/fa";
import { useEffect, useState } from "react";

export default function Dashboard({ fishponds, tempHistories }) {
    const [currentTime, setCurrentTime] = useState(new Date());
    const [temperatureHistory, setTemperatureHistory] = useState([]);
    const [currentPage, setCurrentPage] = useState(0);
    const recordsPerPage = 10;

    useEffect(() => {
        const timer = setInterval(() => {
            setCurrentTime(new Date());
        }, 1000);

        return () => clearInterval(timer);
    }, []);

    useEffect(() => {
        // Populate initial temperature history from props
        setTemperatureHistory(tempHistories);
    }, [tempHistories]);

    const formatDate = (date) => {
        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };
        return new Date(date).toLocaleDateString(undefined, options);
    };

    const formatTime = (date) => {
        return new Date(date).toLocaleTimeString(undefined, {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        });
    };

    const handleFilter = (startDate, endDate) => {
        const filtered = tempHistories.filter((record) => {
            const recordDate = new Date(record.date);
            return (
                (!startDate || recordDate >= new Date(startDate)) &&
                (!endDate || recordDate <= new Date(endDate))
            );
        });
        setTemperatureHistory(filtered);
        setCurrentPage(0); // Reset to first page after filtering
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-0">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {/* Date Time Card */}
                    <div className="mt-10 flex justify-center px-4 mb-5">
                        <div className="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 text-center w-full">
                            <p className="text-lg font-semibold text-blue-600 dark:text-blue-400">
                                {formatDate(currentTime)}{" "}
                                {formatTime(currentTime)}
                            </p>
                        </div>
                    </div>
                    <div className="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                        {fishponds.map((fishpond) => (
                            <div
                                key={fishpond.id}
                                className="w-full sm:w-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center relative"
                            >
                                <FaTemperatureHigh className="absolute top-4 right-4 text-blue-600 dark:text-blue-400 text-xl sm:text-2xl" />
                                <h3 className="text-lg font-bold text-gray-800 dark:text-gray-200">
                                    {fishpond.name}
                                </h3>
                                <p className="text-sm sm:text-base">
                                    Location: {fishpond.location}
                                </p>
                                <p className="text-2xl sm:text-4xl font-extrabold text-blue-600 dark:text-blue-400 mt-4">
                                    {fishpond.temperature}&#176;C
                                </p>

                                <div className="flex flex-col sm:flex-row w-full justify-between mt-4 space-y-2 sm:space-y-0 sm:space-x-2">
                                    <button className="flex-1 rounded-lg bg-indigo-600 px-3 py-2 text-sm text-white font-semibold shadow-lg transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                                        Feed Now
                                    </button>
                                    <button className="flex-1 rounded-lg bg-green-600 px-3 py-2 text-sm text-white font-semibold shadow-lg transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2">
                                        Schedule
                                    </button>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Temperature History */}
                    <div className="mt-10 px-4">
                        <div className="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 sm:p-8 w-full max-w-7xl overflow-x-auto">
                            <h3 className="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                                Fishponds Temperature History
                            </h3>
                            {/* Filters */}
                            <div className="mb-4 flex flex-row gap-4">
                                <div className="flex flex-col sm:flex-row items-start sm:items-center">
                                    <label className="mr-2 mb-2 sm:mb-0 text-sm text-gray-600 dark:text-gray-400">
                                        Sort by:
                                    </label>
                                    <select
                                        className="rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 text-md w-full sm:w-48"
                                        onChange={(e) => {
                                            const sorted = [
                                                ...temperatureHistory,
                                            ].sort((a, b) =>
                                                e.target.value === "asc"
                                                    ? a.fishpond.localeCompare(
                                                          b.fishpond
                                                      )
                                                    : b.fishpond.localeCompare(
                                                          a.fishpond
                                                      )
                                            );
                                            setTemperatureHistory(sorted);
                                        }}
                                    >
                                        {fishponds.map((fishpond) => (
                                            <option
                                                key={fishpond.id}
                                                value={fishpond.name}
                                            >
                                                {fishpond.name}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                                <div className="flex flex-col sm:flex-row items-start sm:items-center">
                                    <label className="mr-2 mb-2 sm:mb-0 text-sm text-gray-600 dark:text-gray-400">
                                        Date Range:
                                    </label>
                                    <div className="flex flex-col sm:flex-row w-full gap-2">
                                        <input
                                            type="date"
                                            className="rounded-md border px-3 py-2 w-full"
                                            onChange={(e) =>
                                                handleFilter(
                                                    e.target.value,
                                                    null
                                                )
                                            }
                                        />
                                        <span className="hidden sm:block mx-2">
                                            to
                                        </span>
                                        <span className="block sm:hidden text-center text-sm text-gray-600 dark:text-gray-400">
                                            to
                                        </span>
                                        <input
                                            type="date"
                                            className="rounded-md border px-3 py-2 w-full"
                                            onChange={(e) =>
                                                handleFilter(
                                                    null,
                                                    e.target.value
                                                )
                                            }
                                        />
                                    </div>
                                </div>
                            </div>{" "}
                            {/* Table */}
                            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead className="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase">
                                            Fishpond
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase">
                                            Temperature
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase">
                                            Date
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase">
                                            Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {temperatureHistory
                                        .slice(
                                            currentPage * recordsPerPage,
                                            (currentPage + 1) * recordsPerPage
                                        )
                                        .map((record) => (
                                            <tr key={record.id}>
                                                <td className="px-6 py-4">
                                                    {record.fishpond}
                                                </td>
                                                <td className="px-6 py-4">
                                                    {record.temperature}&#176;C
                                                </td>
                                                <td className="px-6 py-4">
                                                    {formatDate(record.date)}
                                                </td>
                                                <td className="px-6 py-4">
                                                    {formatTime(record.date)}
                                                </td>
                                            </tr>
                                        ))}
                                </tbody>
                            </table>
                            {/* Pagination */}
                            <div className="mt-4 flex items-center justify-between">
                                <button
                                    onClick={() =>
                                        setCurrentPage((prev) =>
                                            Math.max(0, prev - 1)
                                        )
                                    }
                                    disabled={currentPage === 0}
                                    className="px-3 py-1 bg-gray-200 rounded"
                                >
                                    Previous
                                </button>
                                <span>
                                    Page {currentPage + 1} of{" "}
                                    {Math.ceil(
                                        temperatureHistory.length /
                                            recordsPerPage
                                    )}
                                </span>
                                <button
                                    onClick={() =>
                                        setCurrentPage((prev) =>
                                            Math.min(
                                                Math.ceil(
                                                    temperatureHistory.length /
                                                        recordsPerPage
                                                ) - 1,
                                                prev + 1
                                            )
                                        )
                                    }
                                    disabled={
                                        (currentPage + 1) * recordsPerPage >=
                                        temperatureHistory.length
                                    }
                                    className="px-3 py-1 bg-gray-200 rounded"
                                >
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
