namespace Palabra_Clave
{
    internal class PalabraClave
    {
        static void Main(string[] args)
        {
            string PASSWORD = "eureka";
            string pass;
            int contador = 3;
            bool ok = false;

            Console.WriteLine("Para Acceder Debes Conocer la Contraseña, Tienes 3 Intentos.\n");
            while (contador > 0)
            {
                Console.Write("Introduce la Contraseña: ");
                pass = Console.ReadLine();
                if (pass ==  PASSWORD)
                {
                    contador = 0;
                    ok = true;
                }
                contador--;
            }
            if (!ok)
            {
                Console.WriteLine("Has Exedido los Intentos Permitidos, Se ha Dado Aviso a la Policia.");
            }
        }
    }
}