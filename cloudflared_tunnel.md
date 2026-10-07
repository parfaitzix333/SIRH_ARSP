# 1. Télécharger
wget https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64.deb

# 2. Installer
sudo dpkg -i cloudflared-linux-amd64.deb

# 3. Lancer le tunnel
cloudflared tunnel --url http://localhost:8001

# Ex: d'un test de tunnel
curl https://paul-whats-nest-metadata.trycloudflare.com/health