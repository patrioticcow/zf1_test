<?php
class ContentController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();

        $this->userObj = $userObj = $auth->getStorage()->read();

        $this->view->title = "Content";

        $this->_helper->layout->setLayout('default');
    }

    public function indexAction(){}

    public function actingAction(){
        $this->view->headTitle("Acting Auditions, Find acting tips, auditions, casting calls and more!");
        $this->view->headMeta()->appendName('description', "Acting auditions resource Dedicated to helping actors and models find auditions for film, television, and other acting auditions offered." );
        $this->view->headMeta()->appendName('keywords', "acting, actor, casting, acting, auditions, acting auditions, movie auditions, tv auditions, television auditions" );
    }
    public function actingForKidsAction(){
        $this->view->headTitle("Acting for kids Child Acting TV Acting Movie Auditions for Kids");
        $this->view->headMeta()->appendName('description', "Acting for kids Get your kids started early and start they careers!" );
        $this->view->headMeta()->appendName('keywords', "Acting for kids,kids,acting,exploretalent,explore talent" );
    }
    public function actorAction()
    {
        $this->view->headTitle("Explore Talent Actor Resource");
        $this->view->headMeta()->appendName('description', "Explore Talent Actor resource");
        $this->view->headMeta()->appendName('keywords', "Actor,acting,exploretalent,explore talent");
    }
    public function agentAction()
    {
        $this->view->headTitle("audition for agents, television agent, audition monologues");
        $this->view->headMeta()->appendName('description', "Agent Find an agent for your acting, modeling and anything in the entertainment Business");
        $this->view->headMeta()->appendName('keywords', "Agent, agents, agencies, acting agent, acting agencies, Actor,acting,exploretalent,explore talent");
    }
    public function auditionAction()
    {
        $this->view->headTitle("audition for film, television auditions, monologues");
        $this->view->headMeta()->appendName('description', "Audition Find Auditions at Explore Talent");
        $this->view->headMeta()->appendName('keywords', "Audition Auditions,acting audition, modelind auditions, explore talent, exploretalent");
    }
    public function auditionsActingAction()
    {
        $this->view->headTitle("Explore Talent Acting Auditions");
        $this->view->headMeta()->appendName('description', "Explore Talent Acting Audition and Exploretalent");
        $this->view->headMeta()->appendName('keywords', "acting auditions, auditions, acting, audition, exploretalent, explore talent");
    }
    public function auditionsAction()
    {
        $this->view->headTitle("Auditions at explore talent and audition at exploretalent");
        $this->view->headMeta()->appendName('description', "Find movie auditions in acting, and modeling.");
        $this->view->headMeta()->appendName('keywords', "Auditions, audition, actor,acting,exploretalent,explore talent,agents,acting");
    }
    public function babyModelAction()
    {
        $this->view->headTitle("Explore Talent baby modeling Exploretalent baby model");
        $this->view->headMeta()->appendName('description', "ExploreTalent is the baby model resource on the web for the entertainment industry baby modeling.");
        $this->view->headMeta()->appendName('keywords', "baby modeling,baby model, modeling, explore talent, exploretalent");
    }
    public function becomeAModelAction()
    {
        $this->view->headTitle("Become a Model with Explore Talent and Exploretalent");
        $this->view->headMeta()->appendName('description', "Become a Model today!");
        $this->view->headMeta()->appendName('keywords', "become a model, modeling model, exploretalent explore talent");
    }
    public function broadwayAuditionsAction()
    {
        $this->view->headTitle("Broadway Auditions with Explore Talent and Exploretalent");
        $this->view->headMeta()->appendName('description', "Broadway Auditions with Explore Talent and exploretalent");
        $this->view->headMeta()->appendName('keywords', "broadway auditions, broadway, auditions, audition, acting, acting auditions, exploretalent, explore talent");
    }
    public function castingCallsAction()
    {
        $this->view->headTitle("Casting Calls at Explore Talent and Exploretalent");
        $this->view->headMeta()->appendName('description', "Find casting calls with explore talent and exploretalent.");
        $this->view->headMeta()->appendName('keywords', "Casting Calls, casting call, casting, open casting, audition, auditions, exploretalent, explore talent");
    }
    public function castingAction()
    {
        $this->view->headTitle("casting agencies, casting notices, acting agents in los angeles");
        $this->view->headMeta()->appendName('description', "A casting resource, dedicated to helping actors and models find casting opportunities.");
        $this->view->headMeta()->appendName('keywords', "casting, casting calls, acting, modeling, exploretalent explore talent");
    }
    public function castingauditionsAction()
    {
        $this->view->headTitle("Casting Auditions with explore talent and exploretalent");
        $this->view->headMeta()->appendName('description', "Find Casting Auditions today!");
        $this->view->headMeta()->appendName('keywords', "casting auditions, casting calls, casting, auditions,audition, explore talent, exploretalent");
    }

    public function castingcallAction()
    {
        $this->view->headTitle("open Casting Calls, television and movie casting call");
        $this->view->headMeta()->appendName('description', "Open casting calls for movies and film.");
        $this->view->headMeta()->appendName('keywords', "casting, call, open, television, movie");
    }

    public function childModelAction()
    {
        $this->view->headTitle("Child Modeling at explore talent and exploretalent");
        $this->view->headMeta()->appendName('description', "Child Modeling at Explore Talent.");
        $this->view->headMeta()->appendName('keywords', "child modeling, child, modeling model, kids modeling, audition, auditions, modeling auditions, exploretalent, explore talent");

    }
    public function dancingSchoolsAction()
    {
        $this->view->headTitle("Dancing Schools at Explore Talent with exploretalent");
        $this->view->headMeta()->appendName('description', "Find dancing schools nationwide - los angeles dancing schools, ballet, jazz, ballroom dancing, salsa, tango, hiphop.");
        $this->view->headMeta()->appendName('keywords', "dancing, schools, school, arthur murray, school of dance, schools of dance, instruction, ballet, tap, jazz, jitterbug, dalsa, tango, ballroom, exploretalent, explore talent");
    }
    public function exploreTalentAction()
    {
        $this->view->headTitle("Acting Auditions, Find acting tips, auditions, casting calls and more!");
        $this->view->headMeta()->appendName('description', "Explore Talent acting auditions ExploreTalent modeling auditions Resource dedicated to helping actors and models find auditions for film, television, and other acting auditions offered.");
        $this->view->headMeta()->appendName('keywords', "acting, actor, casting, acting, auditions, acting auditions, movie auditions, tv auditions, television auditions, explore talent, exploretalent");

    }
    public function extrasAction()
    {
        $this->view->headTitle("Exploretalent and explore talent");
        $this->view->headMeta()->appendName('description', "Find  work for film, television.");
        $this->view->headMeta()->appendName('keywords', "movie, tv, casting, , opportunities, director, movies, film");
    }
    public function fashionModelAction()
    {
        $this->view->headTitle("Fashion modeling, teen, male, teen modeling agencies, fashion model and teen search");
        $this->view->headMeta()->appendName('description', "Learn how to become a fashion model and search for work.");
        $this->view->headMeta()->appendName('keywords', "fashion, modeling, male, teen, auditions, actor, tips, information, search, teen");
    }
    public function fashionAction()
    {
        $this->view->headTitle("Get into Fashion with Exploretalent at Explore Talent");
        $this->view->headMeta()->appendName('description', "Get into fashion with exploretalent at Explore Talent");
        $this->view->headMeta()->appendName('keywords', "fashion, get into fashion, fashion model, fashion modeling, explore talent exploretalent");
    }
    public function filmcastingAction()
    {
        $this->view->headTitle("ExploreTalent Film Casting Calls and exploretalent");
        $this->view->headMeta()->appendName('description', "A casting resource, dedicated to helping actors and models find casting opportunities, casting calls, casting directors and other casting offers.");
        $this->view->headMeta()->appendName('keywords', "film casting, casting, casting calls, audition auditions, exploretalent, explore talent");
    }
    public function hotmodelAction()
    {
        $this->view->headTitle("hot models, abercrombie male models, abercrombie fitch male model, black male model");
        $this->view->headMeta()->appendName('description', "Learn how to find female and male modeling gigs.");
        $this->view->headMeta()->appendName('keywords', "casting, hot, model, opportunities, abercrombie fitch, male, black, models");
    }
    public function howToBecomeAModelAction()
    {
        $this->view->headTitle("how to become a model with exploretalent and explore talent");
    }
    public function modelAgenciesAction()
    {
        $this->view->headTitle("list of model agencies, top model agencies, teen fashion");
        $this->view->headMeta()->appendName('description', "Find modeling agencies.");
        $this->view->headMeta()->appendName('keywords', "Modeling agencies, modeling, agencies, agents, model, model agents, models, exploretalent, explore talent");
    }

    public function modelSearchAction()
    {
        $this->view->headTitle("Explore Talent model search with exploretalent");
        $this->view->headMeta()->appendName('description', "Explore Talent Model Search all over the USA");
        $this->view->headMeta()->appendName('keywords', "model search, modeling search, model, models, modeling, explore talent, exploretalent");
    }

    public function modelAction()
    {
        $this->view->headTitle("young models, female models, little girl model, teen, girl model photography young");
        $this->view->headMeta()->appendName('description', "A model resource for young and teen models.");
        $this->view->headMeta()->appendName('keywords', "young, models, female, little, girl, teen, model, photography");
    }

    public function model1Action()
    {
        $this->view->headTitle("young models, female models, little girl model, teen, girl model photography young");
        $this->view->headMeta()->appendName('description', "A model resource for young and teen models.");
        $this->view->headMeta()->appendName('keywords', "young, models, female, little, girl, teen, model, photography");
    }

    public function modelagencyAction()
    {
        $this->view->headTitle("model agency at explore talent and exploretalent");
        $this->view->headMeta()->appendName('description', "Find model agency at explore talent and exploretalent.");
        $this->view->headMeta()->appendName('keywords', "model agency, model agencies, modeling agency, modeling agencies, modeling, model, models, explore talent, exploretalent");
    }
    public function modelingActingAction()
    {
        $this->view->headTitle("Modeling Auditions Casting Calls Modeling Jobs Acting Auditions Agents ExploreTalent Explore Talent");
        $this->view->headMeta()->appendName('description', "Explore Talent - Modeling Auditions Acting Jobs - Talent Profiles");
        $this->view->headMeta()->appendName('keywords', "modeling auditions, model auditions, model, models, modeling, casting modeling, auditions, casting auditions, modeling jobs, exploretalent, explore talent");
    }
    public function modelingAgenciesAction()
    {
        $this->view->headTitle("list of model agencies, top model agencies, teen fashion");
        $this->view->headMeta()->appendName('description', "Find modeling agencies.");
        $this->view->headMeta()->appendName('keywords', "Modeling agencies, modeling, agencies, agents, model, model agents, models, exploretalent, explore talent");

    }
    public function modelingAgencyAction()
    {
        $this->view->headTitle("model agency at explore talent and exploretalent");
        $this->view->headMeta()->appendName('description', "Find model agency at explore talent and exploretalent.");
        $this->view->headMeta()->appendName('keywords', "model agency, model agencies, modeling agency, modeling agencies, modeling, model, models, explore talent, exploretalent");
    }
    public function modelingAuditionsAction()
    {
        $this->view->headTitle("ExploreTalent Modeing Auditions with Exploretalent");
        $this->view->headMeta()->appendName('description', "At ExploreTalent, The Resource for Auditions, Acting Auditions, Modeling Auditions, Casting Calls, and Casting Director information");
        $this->view->headMeta()->appendName('keywords', "modeing auditions, model auditions, auditions, audition, model, models, modeing, exlore talent, exploretalent");
    }

    public function modelsWantedAction()
    {
        $this->view->headTitle("young girl models, little girl model photography, young teen models, beautiful young, art");
        $this->view->headMeta()->appendName('description', "Modeling resouces for aspiring young models and actors.");
        $this->view->headMeta()->appendName('keywords', "young, girl, little, model, photography, beautiful, art, casting, pageants, opportunities");
    }

    public function openauditionsAction()
    {
        $this->view->headTitle("open Auditions with explore talent and exploretalent");
        $this->view->headMeta()->appendName('description', "Open auditions for film, modeling and televisions.");
        $this->view->headMeta()->appendName('keywords', "open auditions, auditions, open audition, casting casting calls, acting, modeling, explore talent, exploretalent");
    }

    public function opencastingcallsAction()
    {
        $this->view->headTitle("Explore Talent Open Casting Calls with Exploretalent");
        $this->view->headMeta()->appendName('description', "Explore Talent open casting calls and open casting call with exploretalent");
        $this->view->headMeta()->appendName('keywords', "open casting calls, open casting call, casting calls, open call, casting, audition, auditions, explore talent, exploretalent");
    }

    public function pageantsAction()
    {
        $this->view->headTitle("Explore Talent Pageants at exploretalent");
        $this->view->headMeta()->appendName('description', "Explore Talent pageanta at exploretalent");
        $this->view->headMeta()->appendName('keywords', "pageant, pageants, be a in a pageant, win a pageant, miss america, miss usa, auditions, audition, casting, casting calls, exploretalent, explore talent");
    }

    public function pagentsAction()
    {
        $this->view->headTitle("beauty pagents, pagent dress");
        $this->view->headMeta()->appendName('description', "Helping you find beauty pagents and related resources.");
        $this->view->headMeta()->appendName('keywords', "casting, pagents, beauty, opportunities, directors, dress");
    }

    public function photographerAction()
    {
        $this->view->headTitle("Explore Talent Photographers Find photographers at exploretalent");
        $this->view->headMeta()->appendName('description', "Explore Talent Photographers Find photographers at exploretalent.");
        $this->view->headMeta()->appendName('keywords', "modeling photographer, model photographer, acting photographer, movie photographer, photographer, explore talent, exploretalent");
    }

    public function resourcesAction()
    {
        $this->view->headTitle("Explore Talent - Industry Resources");
        $this->view->headMeta()->appendName('description', "Explore Talent -  Modeling Acting Jobs - Talent Profiles");
        $this->view->headMeta()->appendName('keywords', "modeling, acting auditions, casting calls, audition, singer, modeing, acting, casting, adition, castings, auditions, search, model, actor, signer, perfomer, casting director, modeling agency, open call, casting call");
    }

    public function screenActorsGuildActorAction()
    {
        $this->view->headTitle("Screen Actors Guild Actor at Explore Talent and Exploretalent");
        $this->view->headMeta()->appendName('description', "Learn how to become an actor today.");
        $this->view->headMeta()->appendName('keywords', "screen actors guild actor, screen actors guild, actor, acting, audition, auditions, exploretalent, explore talent");
    }


    public function theatreAuditionsAction()
    {
        $this->view->headTitle("theatre auditions resource, locate theatre auditions near you including broadway audition");
        $this->view->headMeta()->appendName('keywords', "theatre, auditions, audition, broadway, theatre auditions, casting casting calls, explore talent, exploretalent");
        $this->view->headMeta()->appendName('description', "ExploreTalent's theatre resource. Locate auditions near you including broadway and musicals.");
    }

    public function tryoutsAction()
    {
        $this->view->headTitle("Explore talent tryouts and exploretalent");
        $this->view->headMeta()->appendName('keywords', "tryouts, casting, casting calls, audition, auditions, tryout, exploretalent,explore talent");
        $this->view->headMeta()->appendName('description', "Find explore talent tryouts for modeling, film, extras and movies today!");

    }

    public function webModelsAction()
    {
        $this->view->headTitle("Explore talent web models and exploretalent");
        $this->view->headMeta()->appendName('description', "A resource for explore talent web models and web modeling.");
        $this->view->headMeta()->appendName('keywords', "web models, web modeling, website modeling, website model, internet model, internet modeling, modeling, models, model, auditions, casting, casting calls, audition, explore talent, exploretalent");
    }
}
