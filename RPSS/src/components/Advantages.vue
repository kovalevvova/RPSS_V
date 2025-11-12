<template>
  <section id="advantages" class="advantages-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Почему выбирают нас</h2>
        <p class="section-subtitle">Наши конкурентные преимущества</p>
      </div>
      <div class="advantages-grid">
        <div class="advantage-card" v-for="advantage in advantages" :key="advantage.id">
          <div class="advantage-icon">
            <i :class="advantage.icon"></i>
          </div>
          <h3>{{ advantage.title }}</h3>
          <p>{{ advantage.description }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'Advantages',
  setup() {
    const advantages = ref([
      {
        id: 1,
        icon: 'fas fa-bolt',
        title: 'Оперативность',
        description: 'Выполняем работы в оговоренные сроки, без задержек и переносов. Срочный выезд в течение 2 часов.'
      },
      {
        id: 2,
        icon: 'fas fa-award',
        title: 'Качество',
        description: 'Используем только сертифицированное оборудование от проверенных производителей с гарантией.'
      },
      {
        id: 3,
        icon: 'fas fa-user-tie',
        title: 'Опытные специалисты',
        description: 'Наши сотрудники имеют многолетний опыт и регулярно проходят повышение квалификации.'
      },
      {
        id: 4,
        icon: 'fas fa-ruble-sign',
        title: 'Доступные цены',
        description: 'Предлагаем оптимальное соотношение цены и качества для каждого клиента. Рассрочка платежа.'
      },
      {
        id: 5,
        icon: 'fas fa-shield-alt',
        title: 'Гарантия безопасности',
        description: 'Полное соответствие нормам МЧС. Все работы ведутся согласно требованиям законодательства.'
      },
      {
        id: 6,
        icon: 'fas fa-headset',
        title: 'Круглосуточная поддержка',
        description: 'Техническая поддержка 24/7. Быстрое реагирование на любые неисправности системы.'
      }
    ])

    return {
      advantages
    }
  }
}
</script>