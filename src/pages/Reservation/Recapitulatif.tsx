// 📁 src/pages/Reservation/Recapitulatif.tsx
import { useState, useEffect } from "react";
import Calendar from "react-calendar";
import "react-calendar/dist/Calendar.css";
import "../../styles/calendar.css";

interface Reservation {
  date: string;
  activity?: string;
  people?: number;
  type?: string;
}

export default function RecapitulatifSejour() {
  const [value, setValue] = useState(new Date());
  const [reservations, setReservations] = useState<Reservation[]>([]);

  useEffect(() => {
    const data = JSON.parse(localStorage.getItem("reservations") || "[]");
    setReservations(data);
  }, []);

  const selectedDate = value.toISOString().split("T")[0];

  // Regrouper les réservations par date
  const reservationsByDate = reservations.reduce((acc: Record<string, Reservation[]>, res) => {
    if (!acc[res.date]) acc[res.date] = [];
    acc[res.date].push(res);
    return acc;
  }, {});

  // Couleurs par activité
  const activityColors: Record<string, string> = {
    chambre: "bg-blue-500",
    repas: "bg-yellow-400",
    randonnee: "bg-green-500",
    kayak: "bg-teal-500",
    garderie: "bg-pink-500",
    bagne: "bg-gray-500",
  };

  const tileContent = ({ date }: { date: Date }) => {
    const isoDate = date.toISOString().split("T")[0];
    const dayReservations = reservationsByDate[isoDate] || [];

    return (
      <div className="event-list mt-1 flex flex-wrap justify-center gap-1">
        {dayReservations.map((r, i) => (
          <span
            key={i}
            className={`w-2 h-2 rounded-full ${activityColors[r.activity || ""] || "bg-gray-300"}`}
            title={`${r.activity} (${r.people} pers)`}
          />
        ))}
      </div>
    );
  };

  return (
    <div className="max-w-4xl mx-auto py-10 px-6">
      <h1 className="text-3xl font-bold text-blue-600 text-center mb-6">
        📅 Récapitulatif de votre séjour
      </h1>

      <div className="bg-white rounded-xl p-6 shadow">
        <Calendar
          value={value}
          onChange={setValue}
          tileContent={tileContent}
        />

        <div className="mt-6">
          <h2 className="text-xl font-semibold mb-2 text-gray-800">
            Réservations le {value.toLocaleDateString()} :
          </h2>
          <ul className="list-disc pl-6 text-gray-600">
            {reservations.filter((r) => r.date === selectedDate).length === 0 ? (
              <li>Aucune réservation ce jour-là.</li>
            ) : (
              reservations
                .filter((r) => r.date === selectedDate)
                .map((r, i) => (
                  <li key={i}>
                    {r.activity || r.type || "Activité inconnue"} — {r.people} pers.
                  </li>
                ))
            )}
          </ul>
        </div>

        <div className="mt-10">
          <h2 className="text-xl font-semibold mb-2 text-gray-800">
            Toutes vos réservations :
          </h2>
          <ul className="pl-6 text-gray-600 text-sm space-y-1">
            {reservations.length === 0 ? (
              <li>Aucune réservation enregistrée.</li>
            ) : (
              reservations.map((r, i) => (
                <li key={i}>
                  📍 {r.date} — <strong>{r.activity || r.type}</strong> — {r.people} pers.
                </li>
              ))
            )}
          </ul>
        </div>
      </div>
    </div>
  );
}
