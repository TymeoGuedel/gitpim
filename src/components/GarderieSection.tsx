import { Link } from 'react-router-dom';
import garderieImg from '/assets/woman-showing-colored-picture.jpg';
import enfantsImg from '/assets/children-1547261_1920.jpg';
import dessinCartoon from '/assets/Garderie dessin.png';

export default function GarderieSection() {
  return (
    <section className="bg-[#F4F1EA] py-12 px-4 md:px-16 relative overflow-hidden">
      <div className="grid md:grid-cols-2 gap-10 items-center max-w-6xl mx-auto">
        <div className="space-y-4 z-10">
          <h2 className="text-3xl md:text-4xl font-bold text-[#3DB2FF]">Garderie Enfants</h2>
          <p className="text-gray-700 text-lg">
            Pendant que vous profitez de vos activités, notre équipe accueille vos enfants dans un espace sécurisé, chaleureux et ludique. Ateliers créatifs, jeux, lectures et animations adaptés à chaque âge.
          </p>
          
        </div>

        <div className="relative">
          <img
            src={garderieImg}
            alt="Animatrice avec enfants"
            className="rounded-3xl shadow-xl w-full object-cover h-[300px] md:h-[400px]"
          />
          <img
            src={enfantsImg}
            alt="Groupe d'enfants joyeux"
            className="absolute bottom-[-30px] right-[-30px] w-40 md:w-52 border-4 border-white rounded-full shadow-md"
          />
        </div>
      </div>
      <img
        src={dessinCartoon}
        alt="Dessin cartoon enfants"
        className="absolute bottom-0 left-0 w-32 md:w-40 opacity-80"
      />
    </section>
  );
}
