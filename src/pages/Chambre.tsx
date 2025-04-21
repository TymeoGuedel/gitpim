import ReservationForm from '../components/ReservationForm';

export default function Chambre() {
  return (
    <div className="p-6 md:p-10">
      <h1 className="text-3xl md:text-4xl font-bold text-center text-[#3DB2FF] mb-8">
        Nos Chambres & Bungalows
      </h1>
      <p className="text-center text-gray-600 max-w-2xl mx-auto mb-12">
        Séjournez dans l’un de nos bungalows tout confort : vue mer romantique ou jardin tropical familial. Choisissez votre cocon et réservez en ligne.
      </p>

      <div className="grid md:grid-cols-2 gap-8">
        {/* Bungalow Mer */}
        <div className="bg-white rounded-2xl shadow-md overflow-hidden">
          <img
            src="/assets/bungalow-mer.png"
            alt="Bungalow mer"
            className="w-full h-64 object-cover"
          />
          <div className="p-6">
            <h2 className="text-2xl font-semibold mb-2">Bungalow Vue Mer</h2>
            <p className="text-gray-700 mb-4">
              Profitez de 5 bungalows en front de mer pour 2 personnes. Une vue imprenable sur le lagon au réveil.
            </p>
            <ReservationForm activity="chambre" />
          </div>
        </div>

        {/* Bungalow Jardin */}
        <div className="bg-white rounded-2xl shadow-md overflow-hidden">
          <img
            src="/assets/bungalow-jardin.png"
            alt="Bungalow jardin"
            className="w-full h-64 object-cover"
          />
          <div className="p-6">
            <h2 className="text-2xl font-semibold mb-2">Bungalow Jardin</h2>
            <p className="text-gray-700 mb-4">
              Découvrez nos 10 bungalows nichés dans un écrin de verdure. Idéal pour les familles ou groupes jusqu’à 4 personnes.
            </p>
            <ReservationForm activity="chambre" />
          </div>
        </div>
      </div>
    </div>
  );
}
