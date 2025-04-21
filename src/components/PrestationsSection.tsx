import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import AOS from 'aos';
import 'aos/dist/aos.css';
import 'swiper/css';
import 'swiper/css/pagination';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Pagination } from 'swiper/modules';

const prestations = [
  {
    emoji: '🧗',
    title: 'Randonnée à cheval',
    desc: "Explorez les sentiers de l'île à dos de cheval, accompagnés d’un guide passionné.",
    link: '/randonnee',
  },
  {
    emoji: '🚣',
    title: 'Sortie en kayak',
    desc: 'Naviguez sur le lagon turquoise en kayak, en solo ou en tandem.',
    link: '/kayak',
  },
  {
    emoji: '🍽️',
    title: 'Repas sur place',
    desc: 'Savourez une cuisine locale et conviviale avec vue sur la mer ou le jardin.',
    link: '/repas',
  },
  {
    emoji: '👶',
    title: 'Garderie enfants',
    desc: 'Activités encadrées pour les plus petits pendant que vous profitez du gîte.',
    link: '/garderie',
  },
  {
    emoji: '🏛️',
    title: 'Visite du bagne',
    desc: 'Un moment de mémoire avec la visite guidée du bagne historique de l’île.',
    link: '/bagne',
  },
];

export default function PrestationsCarousel() {
  useEffect(() => {
    AOS.init({ duration: 800 });
  }, []);

  return (
    <section className="bg-[#F4F1EA] py-16 px-4">
      <div className="max-w-4xl mx-auto text-center mb-10">
        <h2 className="text-3xl md:text-4xl font-bold text-[#3DB2FF]">Activités & Prestations</h2>
        <p className="text-gray-600 text-lg mt-2">
          Pour petits et grands, vivez des expériences inoubliables sur l’île de Pam.
        </p>
      </div>

      <Swiper
        slidesPerView={1}
        spaceBetween={20}
        pagination={{ clickable: true }}
        breakpoints={{
          640: { slidesPerView: 1 },
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
        }}
        modules={[Pagination]}
        className="max-w-6xl mx-auto"
      >
        {prestations.map((item) => (
          <SwiperSlide key={item.title}>
            <div
              data-aos="fade-up"
              className="bg-white rounded-3xl shadow-md hover:shadow-xl border-2 border-transparent hover:border-[#3DB2FF] transform hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col justify-between h-full text-center"
            >
              <div className="text-6xl mb-4 drop-shadow-sm">{item.emoji}</div>
              <h3 className="text-lg font-bold text-[#3DB2FF] mb-2">{item.title}</h3>
              <p className="text-gray-600 text-sm mb-4">{item.desc}</p>
              <Link to={item.link}>
                <button className="bg-[#3DB2FF] hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm shadow">
                  Réserver
                </button>
              </Link>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>
    </section>
  );
}
