<template>
  <section id="services" class="services-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Наши услуги</h2>
        <p class="section-subtitle">Полный комплекс услуг по пожарной безопасности</p>
      </div>
      <div class="services-grid">
        <div class="service-card" v-for="service in services" :key="service.id">
          <div class="service-icon">
            <i :class="service.icon"></i>
          </div>
          <h3>{{ service.title }}</h3>
          <p>{{ service.description }}</p>
          <ul class="service-features">
            <li v-for="feature in service.features" :key="feature">
              <i class="fas fa-check"></i>
              {{ feature }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'Services',
  setup() {
    const services = ref([
      {
        id: 1,
        icon: 'fas fa-tools',
        title: 'Установка пожарной сигнализации',
        description: 'Проектирование и монтаж современных систем пожарной сигнализации для объектов любого назначения и сложности.',
        features: [
          'Проектирование под ключ',
          'Современное оборудование',
          'Гарантия качества'
        ]
      },
      {
        id: 2,
        icon: 'fas fa-cogs',
        title: 'Техническое обслуживание',
        description: 'Регулярное обслуживание, проверка и ремонт систем пожарной сигнализации для обеспечения их бесперебойной работы.',
        features: [
          'Плановые проверки',
          'Экстренный ремонт',
          'Профилактика неисправностей'
        ]
      },
      {
        id: 3,
        icon: 'fas fa-drafting-compass',
        title: 'Проектирование и согласование',
        description: 'Разработка проектной документации и получение всех необходимых разрешений в контролирующих органах.',
        features: [
          'Полный пакет документов',
          'Согласование в МЧС',
          'Техническая документация'
        ]
      },
      {
        id: 4,
        icon: 'fas fa-sync-alt',
        title: 'Модернизация систем',
        description: 'Обновление устаревшего оборудования, интеграция с другими системами безопасности объекта.',
        features: [
          'Замена оборудования',
          'Интеграция систем',
          'Повышение эффективности'
        ]
      }
    ])

    return {
      services
    }
  }
}
</script>