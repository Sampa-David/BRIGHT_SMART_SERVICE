FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    postgresql-client \
    libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Copy nginx configuration
COPY nginx.conf.template /etc/nginx/nginx.conf.template

# Create entrypoint script
RUN echo '#!/bin/bash\n\
export PORT="${PORT:-8000}"\n\
envsubst "\${PORT}" < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf\n\
exec "$@"' > /docker-entrypoint.sh \
    && chmod +x /docker-entrypoint.sh

# Expose port
EXPOSE 8000

ENTRYPOINT ["/docker-entrypoint.sh"]

# Start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]