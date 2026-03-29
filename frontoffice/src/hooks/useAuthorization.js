import { useAuth } from "@contexts/auth.context";

/**
 * Hook pour vérifier les autorisations de l'utilisateur
 */
const useAuthorization = () => {
  const { user, isAuthenticated } = useAuth();

  const hasRole = (role) => {
    return user?.role === role;
  };

  const hasPermission = (permission) => {
    return user?.permissions?.includes(permission);
  };

  return {
    isAuthenticated,
    user,
    hasRole,
    hasPermission,
  };
};

export default useAuthorization;
