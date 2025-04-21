import ReservationLayout from '../components/ReservationLayout';

export default function Kayak() {
  return (
    <ReservationLayout
      activity="kayak"
      title="Sortie en Kayak"
      emoji="🛶"
      description="Pagayez à travers le lagon turquoise, en solo ou en tandem."
      infoList={[
        '🌊 Excursion sur le lagon calme et sécurisé',
        '🛶 3 kayaks doubles, 2 simples',
        '👥 Groupe de 8 personnes max',
        '📅 Réservez pendant votre séjour'
      ]}
      image="/assets/kayak1.png"
      themeColor="#0EA5E9"
    />
  );
}
