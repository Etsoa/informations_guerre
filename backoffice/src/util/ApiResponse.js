/**
 * Classe utilitaire pour formater les réponses API de manière cohérente
 */
class ApiResponse {
  /**
   * Réponse de succès
   */
  static success(res, data = null, message = "Succès", statusCode = 200) {
    return res.status(statusCode).json({
      success: true,
      message,
      data,
    });
  }

  /**
   * Réponse de création réussie
   */
  static created(res, data = null, message = "Ressource créée avec succès") {
    return ApiResponse.success(res, data, message, 201);
  }

  /**
   * Réponse d'erreur
   */
  static error(res, message = "Erreur interne du serveur", statusCode = 500) {
    return res.status(statusCode).json({
      success: false,
      message,
    });
  }

  /**
   * Réponse 404
   */
  static notFound(res, message = "Ressource non trouvée") {
    return ApiResponse.error(res, message, 404);
  }

  /**
   * Réponse 400
   */
  static badRequest(res, message = "Requête invalide") {
    return ApiResponse.error(res, message, 400);
  }
}

module.exports = ApiResponse;
