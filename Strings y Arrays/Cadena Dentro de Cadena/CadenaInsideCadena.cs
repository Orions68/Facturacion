namespace Cadena_Dentro_de_Cadena
{
    internal class CadenaInsideCadena
    {
        static void Main(string[] args)
        {
            string cadena1;
            string cadena2;
            int n = 0;
            char seguir = 's';

            while (seguir == 's')
            {
                Console.WriteLine("Este Programa Muestra si la Segunda Cadena Dada, Está dentro de la Primera.\n");
                Console.Write("Introduce la Primera Cadena: ");
                cadena1 = Console.ReadLine();
                Console.WriteLine();
                Console.Write("Introduce la Segunda Cadena: ");
                cadena2 = Console.ReadLine();
                Console.WriteLine();
                for (int i = 0; i < cadena1.Length; i++)
                {
                    if (cadena1[i] == cadena2[n])
                    {
                        if (n == cadena2.Length - 1)
                        {
                            Console.WriteLine("Está\n");
                        }
                        else
                        {
                            n++;
                        }
                    }
                    else
                    {
                        n = 0;
                    }
                }
                Console.WriteLine("Presiona la Tecla s Para Introducir Otra Palabra, Cuanlquier otra Tecla Para Salir.");
                seguir = Console.ReadKey().KeyChar;
                n = 0;
                Console.Clear();
            }
            Console.WriteLine("Presiona Cualquier Tecla Para Salir.");
            Console.ReadKey();
        }
    }
}