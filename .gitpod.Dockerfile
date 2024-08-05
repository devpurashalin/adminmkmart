FROM gitpod/workspace-full

# Install PHP and extensions
RUN sudo apt-get update && sudo apt-get install -y \
    php-cli \
    php-mbstring \
    php-xml \
    php-mysql \
    php-sqlite3

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -
RUN sudo apt-get install -y nodejs
