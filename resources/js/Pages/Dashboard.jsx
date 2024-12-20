import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { FaTemperatureHigh } from "react-icons/fa";
import { useEffect, useState } from "react";

export default function Dashboard() {
    const [currentTime, setCurrentTime] = useState(new Date());
    const [temperatureHistory, setTemperatureHistory] = useState([
        {
            id: 1,
            fishpond: "Fishpond 1",
            temperature: "28°C",
            date: new Date(),
        },
        {
            id: 2,
            fishpond: "Fishpond 2",
            temperature: "26°C",
            date: new Date(),
        },
    ]);

    useEffect(() => {
        const timer = setInterval(() => {
            setCurrentTime(new Date());
        }, 1000);

        return () => clearInterval(timer);
    }, []);

    const formatDate = (date) => {
        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };
        return date.toLocaleDateString(undefined, options);
    };

    const formatTime = (date) => {
        return date.toLocaleTimeString(undefined, {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        });
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

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="flex justify-center space-x-6">
                        {/* Card 1 */}
                        <div className="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center relative">
                            <h3 className="text-lg font-bold text-gray-800 dark:text-gray-200">
                                Water Fishpond 1
                            </h3>
                            <p className="text-4xl font-extrabold text-blue-600 dark:text-blue-400 mt-4">
                                28°C
                            </p>
                            <FaTemperatureHigh className="absolute bottom-4 right-4 text-blue-600 dark:text-blue-400 text-2xl" />
                        </div>

                        {/* Card 2 */}
                        <div className="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center relative">
                            <h3 className="text-lg font-bold text-gray-800 dark:text-gray-200">
                                Water Fishpond 2
                            </h3>
                            <p className="text-4xl font-extrabold text-blue-600 dark:text-blue-400 mt-4">
                                26°C
                            </p>
                            <FaTemperatureHigh className="absolute bottom-4 right-4 text-blue-600 dark:text-blue-400 text-2xl" />
                        </div>
                    </div>

                    {/* Date Time Card */}
                    <div className="mt-10 flex justify-center">
                        <div className="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 text-center w-full max-w-3xl">
                            <h3 className="text-xl font-bold text-gray-800 dark:text-gray-200">
                                Current Date & Time
                            </h3>
                            <p className="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mt-4">
                                {formatDate(currentTime)}{" "}
                                {formatTime(currentTime)}
                            </p>

                            <div className="flex w-full justify-between mt-4">
                                <button className="flex-1 mx-2 rounded-lg bg-indigo-600 px-3 py-1 text-sm text-white font-semibold shadow-lg transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                                    Feed Now
                                </button>
                                <button className="flex-1 mx-2 rounded-lg bg-green-600 px-3 py-1 text-sm text-white font-semibold shadow-lg transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2">
                                    Schedule
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Temperature History Table */}
                    <div className="mt-10">
                        <div className="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 w-full max-w-7xl">
                            <h3 className="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                                Fishponds Temperature History
                            </h3>
                            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead className="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Fishpond
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Temperature
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {temperatureHistory.map((record) => (
                                        <tr key={record.id}>
                                            <td className="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {record.fishpond}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {record.temperature}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {formatDate(record.date)}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {formatTime(record.date)}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
