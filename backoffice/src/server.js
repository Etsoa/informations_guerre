require("dotenv").config();
const express = require("express");
const cors = require("cors");
const { sequelize } = require("./model");
const routes = require("./route");

const app = express();
const PORT = process.env.PORT || 3000;

// Middlewares globaux
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Routes
app.use("/api", routes);

// Route de test
app.get("/", (req, res) => {
  res.json({ message: "API is running" });
});

// Connexion à la base de données et démarrage du serveur
sequelize
  .authenticate()
  .then(() => {
    console.log("✅ Connexion à PostgreSQL réussie.");

    // Synchroniser les modèles (en dev uniquement)
    if (process.env.NODE_ENV === "development") {
      sequelize.sync({ alter: true }).then(() => {
        console.log("✅ Modèles synchronisés.");
      });
    }

    app.listen(PORT, () => {
      console.log(`Serveur démarré sur le port ${PORT}`);
    });
  })
  .catch((err) => {
    console.error("Erreur de connexion à PostgreSQL :", err);
  });

module.exports = app;
