// 📁 src/components/Meteo.tsx
type Props = {
  date: string;
};

const Meteo = ({ date }: Props) => {
  // Simulation météo (aléatoire)
  const types = ['ensoleillé', 'nuageux', 'pluvieux', 'orageux'];
  const meteo = types[new Date(date).getDate() % types.length];

  const icons: { [key: string]: string } = {
    ensoleillé: '☀️',
    nuageux: '☁️',
    pluvieux: '🌧️',
    orageux: '⛈️',
  };

  const couleurs: { [key: string]: string } = {
    ensoleillé: 'text-yellow-500',
    nuageux: 'text-gray-500',
    pluvieux: 'text-blue-500',
    orageux: 'text-purple-600',
  };

  return (
    <div className={`flex items-center gap-2 mt-2 text-sm ${couleurs[meteo]}`}>
      <span className="text-2xl">{icons[meteo]}</span>
      <span>Météo prévue : {meteo}</span>
    </div>
  );
};

export default Meteo;
