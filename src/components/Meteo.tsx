import { useEffect, useState } from 'react';

type Props = {
  date: string;
  latitude?: number;
  longitude?: number;
};

const Meteo = ({ date, latitude = -22.2558, longitude = 166.4505 }: Props) => {
  const [meteo, setMeteo] = useState<string | null>(null);
  const [temperature, setTemperature] = useState<{ min: number; max: number } | null>(null);
  const [loading, setLoading] = useState(true);

  const icons: { [key: string]: string } = {
    clear: '☀️',
    partly_cloudy: '🌤️',
    cloudy: '☁️',
    rain: '🌧️',
    thunderstorm: '⛈️',
    snow: '❄️',
    fog: '🌫️',
  };

  const couleurs: { [key: string]: string } = {
    clear: 'text-yellow-500',
    partly_cloudy: 'text-yellow-300',
    cloudy: 'text-gray-500',
    rain: 'text-blue-500',
    thunderstorm: 'text-purple-600',
    snow: 'text-blue-200',
    fog: 'text-gray-400',
  };

  const libellesFR: { [key: string]: string } = {
    clear: 'Ciel dégagé',
    partly_cloudy: 'Partiellement nuageux',
    cloudy: 'Couvert',
    rain: 'Pluie',
    thunderstorm: 'Orage',
    snow: 'Neige',
    fog: 'Brouillard',
  };

  const conseils: { [key: string]: string } = {
    clear: 'Bonne journée ensoleillée !',
    partly_cloudy: 'Journée agréable, quelques nuages.',
    cloudy: 'Le ciel sera bien couvert.',
    rain: 'Prévoyez un imperméable ☔',
    thunderstorm: 'Attention aux orages !',
    snow: 'Temps hivernal, couvrez-vous bien.',
    fog: 'Visibilité réduite, soyez prudents.',
  };

  useEffect(() => {
    const fetchMeteo = async () => {
      try {
        const targetDate = new Date(date).toISOString().split('T')[0];
        const response = await fetch(
          `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&daily=weathercode,temperature_2m_max,temperature_2m_min&timezone=auto&start_date=${targetDate}&end_date=${targetDate}`
        );
        const data = await response.json();
        const code = data.daily.weathercode[0];
        const tmin = data.daily.temperature_2m_min[0];
        const tmax = data.daily.temperature_2m_max[0];

        const codeToType: { [key: number]: string } = {
          0: 'clear',
          1: 'partly_cloudy',
          2: 'cloudy',
          3: 'cloudy',
          45: 'fog',
          48: 'fog',
          51: 'rain',
          61: 'rain',
          63: 'rain',
          65: 'rain',
          71: 'snow',
          73: 'snow',
          75: 'snow',
          80: 'rain',
          95: 'thunderstorm',
        };

        const type = codeToType[code] || 'cloudy';
        setMeteo(type);
        setTemperature({ min: tmin, max: tmax });
      } catch (err) {
        console.error('Erreur de récupération météo :', err);
        setMeteo(null);
      } finally {
        setLoading(false);
      }
    };

    fetchMeteo();
  }, [date, latitude, longitude]);

  if (loading) return <p className="mt-2 text-sm text-gray-400">Chargement de la météo...</p>;
  if (!meteo) return <p className="mt-2 text-sm text-red-500">Météo indisponible</p>;

  return (
    <div className={`flex flex-col mt-2 text-sm ${couleurs[meteo]}`}>
      <div className="flex items-center gap-2">
        <span className="text-2xl">{icons[meteo]}</span>
        <span>Météo prévue : {libellesFR[meteo] || meteo}</span>
      </div>
      {temperature && (
        <span className="ml-8 text-gray-700">
          🌡️ {temperature.min}°C à {temperature.max}°C
        </span>
      )}
      {meteo && (
        <span className="ml-8 italic text-gray-500">{conseils[meteo]}</span>
      )}
    </div>
  );
};

export default Meteo;
