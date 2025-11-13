<template>
  <section class="hero" id="home">
    <!-- Анимация дыма из труб -->
    <div class="smoke-animation">
      <div class="smoke smoke-1"></div>
      <div class="smoke smoke-2"></div>
      <div class="smoke smoke-3"></div>
      <div class="smoke smoke-4"></div>

      <div class="steam steam-1"></div>
      <div class="steam steam-2"></div>

      <div class="factory-lights">
        <div class="light light-1"></div>
        <div class="light light-2"></div>
        <div class="light light-3"></div>
        <div class="light light-4"></div>
        <div class="light light-5"></div>
      </div>
    </div>

    <div class="container">
      <div class="hero-content">
        <div class="hero-badge">
          <span>Надежная защита с 2017 года</span>
        </div>
        <h1 class="hero-title">
          Профессиональная установка и обслуживание
          <span class="highlight">пожарной сигнализации</span>
        </h1>
        <p class="hero-description">
          Обеспечиваем полную пожарную безопасность для вашего дома, офиса или предприятия.
          Работаем с физическими и юридическими лицами по Усинску и Усинскому району.
        </p>
        <div class="hero-actions">
          <a href="#contacts" class="btn btn-primary">
            <i class="fas fa-calendar-check"></i>
            Заказать консультацию
          </a>
          <a href="#services" class="btn btn-secondary">
            <i class="fas fa-info-circle"></i>
            Наши услуги
          </a>
        </div>
        <div class="hero-stats">
          <div class="stat">
            <div class="stat-number">6+</div>
            <div class="stat-label">лет опыта</div>
          </div>
          <div class="stat">
            <div class="stat-number">500+</div>
            <div class="stat-label">объектов защищено</div>
          </div>
          <div class="stat">
            <div class="stat-number">24/7</div>
            <div class="stat-label">техподдержка</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Hero'
}
</script>