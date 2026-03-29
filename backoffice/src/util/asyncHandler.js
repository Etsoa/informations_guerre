/**
 * Wrapper pour les fonctions async des contrôleurs
 * Capture automatiquement les erreurs et les passe au middleware errorHandler
 */
const asyncHandler = (fn) => (req, res, next) => {
  Promise.resolve(fn(req, res, next)).catch(next);
};

module.exports = asyncHandler;
