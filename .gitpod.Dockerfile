FROM gitpod/workspace-full

# Install PHP and extensions
RUN sudo apt-get update && sudo apt-get install -y \
    php-cli \
    php-mbstring \
    php-xml \
    php-mysql \
    php-sqlite3 \
    openssl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -
RUN sudo apt-get install -y nodejs

# Install MySQL
RUN sudo apt-get install -y mysql-server

# Enable MySQL extensions
RUN sudo docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 8000 for Laravel
EXPOSE 8000

# Start MySQL service
CMD sudo service mysql start && tail -f /dev/null
