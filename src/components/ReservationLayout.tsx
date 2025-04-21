import { useNavigate } from 'react-router-dom';
import Carousel from '../components/Carousel';
import ReservationForm from '../components/ReservationForm';

interface Props {
  activity: 'chambre' | 'repas' | 'randonnee' | 'kayak' | 'garderie' | 'bagne';
  title: string;
  emoji: string;
  description: string;
  infoList: string[];
  image: string;
  themeColor: string;
}

export default function ReservationLayout({
  activity,
  title,
  emoji,
  description,
  infoList,
  image,
  themeColor,
}: Props) {
  const navigate = useNavigate();

  return (
    <div className="relative bg-[#F4F1EA] overflow-hidden">
      <div className={`absolute top-0 left-0 w-[900px] h-[900px] rounded-full -z-10`} style={{ backgroundColor: `${themeColor}33` }}></div>
      <div className={`absolute bottom-0 right-0 w-[1000px] h-[1000px] rounded-full -z-10`} style={{ backgroundColor: `${themeColor}22` }}></div>

      <div className="relative z-10 max-w-7xl mx-auto px-6 py-16">
        <h1 className={`text-3xl md:text-4xl font-bold text-center`} style={{ color: themeColor }}>{title} {emoji}</h1>
        <p className="text-center mt-4 text-gray-700 text-lg">{description}</p>

        <div className="mt-16 flex flex-col lg:flex-row gap-10 items-center">
          <div className="w-full lg:w-1/2">
            <img src={image} alt={title} className="rounded-3xl shadow-xl object-cover w-full h-[400px]" />
          </div>
          <div className="w-full lg:w-1/2 space-y-4">
            <h3 className="text-xl font-semibold">Informations</h3>
            <ul className="text-gray-700 space-y-2">
              {infoList.map((item, i) => (
                <li key={i}>{item}</li>
              ))}
            </ul>
          </div>
        </div>

        <div className="mt-20 flex flex-col lg:flex-row gap-12 items-stretch">
          <div className="flex-1 flex flex-col justify-center">
            <h3 className={`text-xl font-semibold text-center mb-6`} style={{ color: themeColor }}>En images</h3>
            <Carousel activity={activity} />
          </div>

          <div className="flex-1 bg-white p-8 rounded-xl shadow-md w-full self-center">
            <h3 className="text-xl font-semibold text-center mb-4">Réserver</h3>
            <ReservationForm
   activity={activity}
  onConfirm={(data) => {
    const existing = JSON.parse(localStorage.getItem("reservations") || "[]");
    const newReservation = { ...data, activity };
    console.log("📦 Réservation enregistrée :", newReservation); // 👈 AJOUT
    localStorage.setItem("reservations", JSON.stringify([...existing, newReservation]));
    navigate("/reservation/confirmation", { state: newReservation });
  }}
/>


          </div>
        </div>
      </div>
    </div>
  );
}
