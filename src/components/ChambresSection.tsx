import { Link } from 'react-router-dom';

export default function ChambresSection() {
  return (
    <section className="bg-white py-16 px-4 md:px-16">
      <div className="max-w-6xl mx-auto text-center mb-10">
        <h2 className="text-3xl md:text-4xl font-bold text-[#3DB2FF]">Nos Bungalows</h2>
        <p className="text-gray-600 text-lg mt-2">
          Deux ambiances pour un séjour paisible : en bord de mer ou au cœur de notre jardin tropical.
        </p>
      </div>

      <div className="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
        {/* Bungalow Mer */}
        <div className="bg-[#F4F1EA] rounded-3xl overflow-hidden shadow-xl">
          <img src="/assets/bungalow-mer.png" alt="Bungalow vue mer" className="w-full h-64 object-cover" />
          <div className="p-6 text-left">
            <h3 className="text-2xl font-semibold mb-2">Bungalow Vue Mer</h3>
            <p className="text-gray-700 mb-4">
              5 bungalows pour 2 personnes, vue imprenable sur le lagon, parfait pour un séjour en couple ou en solo.
            </p>
            <Link to="/reservation">


              <button className="bg-[#3DB2FF] hover:bg-blue-600 text-white px-5 py-2 rounded-lg transition">
                Réserver
              </button>
            </Link>
          </div>
        </div>

        {/* Bungalow Jardin */}
        <div className="bg-[#F4F1EA] rounded-3xl overflow-hidden shadow-xl">
          <img src="/assets/bungalow-jardin.png" alt="Bungalow jardin" className="w-full h-64 object-cover" />
          <div className="p-6 text-left">
            <h3 className="text-2xl font-semibold mb-2">Bungalow Jardin</h3>
            <p className="text-gray-700 mb-4">
              10 bungalows pour 4 personnes nichés dans un cadre verdoyant, idéal pour les familles ou groupes d’amis.
            </p>
            <Link to="/reservation">


              <button className="bg-[#3DB2FF] hover:bg-blue-600 text-white px-5 py-2 rounded-lg transition">
                Réserver
              </button>
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
}
