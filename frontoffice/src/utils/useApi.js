import { useState, useCallback } from "react";
import api from "@api/index";

/**
 * Hook utilitaire pour les appels API
 * Gère le loading, les données et les erreurs
 */
const useApi = () => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const request = useCallback(async (method, url, data = null) => {
    setLoading(true);
    setError(null);

    try {
      const response = await api({ method, url, data });
      return response.data;
    } catch (err) {
      const message = err.response?.data?.message || "Une erreur est survenue.";
      setError(message);
      throw err;
    } finally {
      setLoading(false);
    }
  }, []);

  const get = useCallback((url) => request("GET", url), [request]);
  const post = useCallback((url, data) => request("POST", url, data), [request]);
  const put = useCallback((url, data) => request("PUT", url, data), [request]);
  const del = useCallback((url) => request("DELETE", url), [request]);

  return { loading, error, get, post, put, del };
};

export default useApi;
