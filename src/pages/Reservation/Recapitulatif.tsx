import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import Calendar from "react-calendar";
import "react-calendar/dist/Calendar.css";
import "../../styles/calendar.css";

interface Reservation {
  date: string;
  activity?: string;
  people?: number;
  type?: string;
}

export default function Recapitulatif() {
  const [value, setValue] = useState(new Date());
  const [reservations, setReservations] = useState<Reservation[]>([]);
  const [bungalow, setBungalow] = useState('');
  const [dateArrivee, setDateArrivee] = useState('');
  const [dateDepart, setDateDepart] = useState('');
  const [personnes, setPersonnes] = useState('');
  const [numeroReservation, setNumeroReservation] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    const data = JSON.parse(localStorage.getItem("reservations") || "[]");
    setReservations(data);

    const storedBungalow = localStorage.getItem('bungalow');
    const storedArrivee = localStorage.getItem('dateArrivee');
    const storedDepart = localStorage.getItem('dateDepart');
    const storedPersonnes = localStorage.getItem('personnes');
    const storedNumero = localStorage.getItem('numeroReservation');

    if (!storedBungalow || !storedArrivee || !storedDepart || !storedPersonnes || !storedNumero) {
      navigate('/reservation');
    } else {
      setBungalow(storedBungalow);
      setDateArrivee(storedArrivee);
      setDateDepart(storedDepart);
      setPersonnes(storedPersonnes);
      setNumeroReservation(storedNumero);
    }
  }, [navigate]);

  const selectedDate = value.toISOString().split("T")[0];

  const reservationsByDate = reservations.reduce((acc: Record<string, Reservation[]>, res) => {
    if (!acc[res.date]) acc[res.date] = [];
    acc[res.date].push(res);
    return acc;
  }, {});

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

  const tileClassName = ({ date }: { date: Date }) => {
    if (!dateArrivee || !dateDepart) return '';
    const dateISO = date.toISOString().split("T")[0];
    return (dateISO >= dateArrivee && dateISO < dateDepart) ? 'bg-blue-200 rounded-full' : '';
  };

  const calcDuree = () => {
    const d1 = new Date(dateArrivee);
    const d2 = new Date(dateDepart);
    const diff = (d2.getTime() - d1.getTime()) / (1000 * 3600 * 24);
    return diff;
  };

  return (
    <div className="max-w-4xl mx-auto py-10 px-6">
      <h1 className="text-3xl font-bold text-blue-600 text-center mb-6">
        🧾 Récapitulatif de votre séjour
      </h1>

      <div className="bg-white rounded-xl p-6 shadow mb-10 text-gray-800 space-y-2">
        <p><strong>Bungalow :</strong> {bungalow === 'mer' ? 'Vue Mer (2 pers max)' : 'Jardin (4 pers max)'}</p>
        <p><strong>Nombre de personnes :</strong> {personnes}</p>
        <p><strong>Dates :</strong> du {dateArrivee} au {dateDepart} — <strong>{calcDuree()} nuit(s)</strong></p>
        <p><strong>Numéro de réservation :</strong> <span className="font-mono text-blue-600">{numeroReservation}</span></p>
      </div>

      <div className="bg-white rounded-xl p-6 shadow">
        <Calendar
          value={value}
          onChange={setValue}
          tileContent={tileContent}
          tileClassName={tileClassName}
        />

        <div className="mt-6">
          <h2 className="text-xl font-semibold mb-2 text-gray-800">
            Activités le {value.toLocaleDateString()} :
          </h2>
          <ul className="list-disc pl-6 text-gray-600">
            {reservations.filter((r) => r.date === selectedDate).length === 0 ? (
              <li>Aucune activité ce jour-là.</li>
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
      </div>
    </div>
  );
}
