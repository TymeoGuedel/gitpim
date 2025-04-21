import ReservationLayout from '../components/ReservationLayout';

export default function Repas() {
  return (
    <ReservationLayout
      activity="repas"
      title="Repas au gîte"
      emoji="🍽️"
      description="Savourez une cuisine locale et chaleureuse au cœur de l'île."
      infoList={[
        '🍽️ Plats faits maison avec produits locaux',
        '👨‍👩‍👧‍👦 Ambiance conviviale en terrasse',
        '🪑 30 couverts par créneau',
        '📅 Réservez pendant votre séjour'
      ]}
      image="/assets/Zoomsurlesplats.png"
      themeColor="#F97316"
    />
  );
}