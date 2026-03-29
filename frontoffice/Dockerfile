# ================================
# Etape 1 : Build React avec Node
# ================================
FROM node:20-alpine AS build

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# ================================
# Etape 2 : Servir avec Apache
# ================================
FROM httpd:2.4-alpine

# Activer les modules nécessaires pour le URL rewriting
RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i '/LoadModule proxy_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i '/LoadModule proxy_http_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i 's/AllowOverride None/AllowOverride All/g' /usr/local/apache2/conf/httpd.conf

# Copier la config Apache personnalisée
COPY apache.conf /usr/local/apache2/conf/extra/app.conf
RUN echo "Include conf/extra/app.conf" >> /usr/local/apache2/conf/httpd.conf

# Copier le build React dans le dossier Apache
COPY --from=build /app/dist/ /usr/local/apache2/htdocs/

# Copier le .htaccess
COPY .htaccess /usr/local/apache2/htdocs/.htaccess

EXPOSE 80
