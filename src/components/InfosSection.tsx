import Meteo from './Meteo';

export default function InfosSection() {
  const today = new Date().toISOString().split('T')[0];

  return (
    <section className="bg-white py-16 px-4 md:px-16">
      <div className="max-w-6xl mx-auto">
        <h2 className="text-3xl md:text-4xl font-bold text-[#3DB2FF] text-center mb-10">Infos Pratiques</h2>

        <div className="grid md:grid-cols-2 gap-12">
          {/* Bloc infos */}
          <div className="space-y-4">
            <p className="text-gray-700">
              <strong>📍 Adresse :</strong> Île de Pam, proche de Poum, Province Nord, Nouvelle-Calédonie.
            </p>
            <p className="text-gray-700">
              <strong>📞 Téléphone :</strong> +687 99 99 99
            </p>
            <p className="text-gray-700">
              <strong>✉️ Email :</strong> contact@gitepim.nc
            </p>
            <p className="text-gray-700">
              <strong>🕐 Horaires :</strong> Accueil tous les jours de 7h30 à 18h
            </p>

            <div className="mt-4">
              <Meteo date={today} />
            </div>
          </div>

          {/* Carte visuelle (iframe ou image) */}
          <div>
            <iframe
              title="Gîte Pim map"
              className="rounded-2xl w-full h-80 border shadow-lg"
              loading="lazy"
              allowFullScreen
              src="https://maps.google.com/maps?q=poum%20nouvelle%20caledonie&t=&z=13&ie=UTF8&iwloc=&output=embed"
            ></iframe>
          </div>
        </div>
      </div>
    </section>
  );
}
