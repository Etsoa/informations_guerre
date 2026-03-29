/**
 * Middleware d'authentification
 * Vérifie le token d'accès dans les headers de la requête
 */
const authentification = (req, res, next) => {
  try {
    const authHeader = req.headers.authorization;

    if (!authHeader) {
      return res.status(401).json({
        success: false,
        message: "Token d'authentification manquant.",
      });
    }

    const token = authHeader.split(" ")[1];

    if (!token) {
      return res.status(401).json({
        success: false,
        message: "Format de token invalide.",
      });
    }

    // TODO: Vérifier et décoder le token (ex: jwt.verify)
    // const decoded = jwt.verify(token, process.env.JWT_SECRET);
    // req.user = decoded;

    next();
  } catch (error) {
    return res.status(403).json({
      success: false,
      message: "Token invalide ou expiré.",
    });
  }
};

module.exports = authentification;
