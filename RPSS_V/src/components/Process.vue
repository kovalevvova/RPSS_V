<template>
  <section id="process" class="process-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Как мы работаем</h2>
        <p class="section-subtitle">Процесс сотрудничества от заявки до сдачи объекта</p>
      </div>
      <div class="process-steps">
        <div class="process-step" v-for="step in processSteps" :key="step.id">
          <div class="step-number">{{ step.number }}</div>
          <div class="step-content">
            <div class="step-icon">
              <i :class="step.icon"></i>
            </div>
            <h3>{{ step.title }}</h3>
            <p>{{ step.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'Process',
  setup() {
    const processSteps = ref([
      {
        id: 1,
        number: '01',
        icon: 'fas fa-phone-alt',
        title: 'Консультация',
        description: 'Бесплатный выезд специалиста, оценка объекта и расчет стоимости. Обсуждение всех деталей проекта.'
      },
      {
        id: 2,
        number: '02',
        icon: 'fas fa-drafting-compass',
        title: 'Проектирование',
        description: 'Разработка индивидуального проекта с учетом особенностей объекта. Согласование с заказчиком.'
      },
      {
        id: 3,
        number: '03',
        icon: 'fas fa-hammer',
        title: 'Монтаж',
        description: 'Установка оборудования с соблюдением всех норм и требований. Минимальное вмешательство в отделку.'
      },
      {
        id: 4,
        number: '04',
        icon: 'fas fa-clipboard-check',
        title: 'Сдача в эксплуатацию',
        description: 'Пуско-наладочные работы и обучение персонала. Подписание актов выполненных работ.'
      }
    ])

    return {
      processSteps
    }
  }
}
</script>